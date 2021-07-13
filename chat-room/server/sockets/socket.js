let admin_roomIdx = ""
const {io} = require('../server')
const {knex} = require('../server')
const {
    checkInPacket,
    deleteUserByClientId,
    getUserByRoomIdxAndClientId,
    deleteMsgByRoomIdx,
    getUserFromIdAndRoomIdx,
    refreshChatByRoomIdx,
    setUserMuteById,
    setUserManageById,
    setFixManageById,
    getUsersByRoomIdx,
    setUserItem,
    adminRealtime,
    setAdminConfig,
    getUser

} = require('../utils/utils')

let public_msg = new Array();
let private_msg = new Array();

let presult = io.of('/result');
presult.on("connection",(client) => {
    client.on('disconnect', () => {

    })
    client.on("receive",(data,callback) => {
        presult.emit("result",data);
    })
});

let public = io.of("/public");
public.on("connection",(client) => {
    client.on('disconnect', () => {
        let deleted_user = deleteUserByClientId(client.id);
        if(typeof deleted_user !=='undefined')
        {
            public.to(deleted_user.roomIdx).emit("receive",{header:{type:"LeaveUserId"},body:{userIdKey:deleted_user.id}})
            client.leave(deleted_user.roomIdx)
        }
    })
    client.on("touser",(data,callback)=>{
      let t_user = getUserFromIdAndRoomIdx(data.userIdKey,"channel1")
      if(typeof  t_user !="undefined"){
        public.to(t_user.clientId).emit("touser",data)
      }
    })

    client.on("miss",(data,callback)=>{
      public.emit("tomiss",data)
    })
    client.on("send",(data,callback) => {
        if(data.header.type == "GIFT"){
            let t_user = getUserFromIdAndRoomIdx(data.body.tuseridKey,data.body.roomIdx)
            if(typeof  t_user !="undefined"){
                let user = getUserByRoomIdxAndClientId(client.id,data.body.roomIdx);
                if(typeof user != "undefined"){
                    public.to(data.body.roomIdx).emit("receive",{header:{type:"CMDMSG"},body:{cmd:"gift",cnt:data.body.cnt,type:data.body.type,tnickname:t_user.nickname,nickname: user.nickname}});
                }
            }
        }
        else
        {
            checkInPacket(data,client,public);
        }
    })
    client.on("receive",(data,callback) =>{
      if(data.body.cmd == "powerballResult"){
        client.to(data.body.roomIdx).emit("receive",data);
        setTimeout(function(){
            roomio.emit("receive",data);
        },1000)
      }
    })
});

let roomio = io.of('/room');

roomio.on("connection",(client) => {
    client.on('disconnect', () => {
        let deleted_user = deleteUserByClientId(client.id);
        if(typeof deleted_user !=='undefined')
        {
            roomio.to(deleted_user.roomIdx).emit("receive",{header:{type:"LeaveUserId"},body:{userIdKey:deleted_user.id}})
            client.leave(deleted_user.roomIdx)
            if(typeof deleted_user.roomIdx !="undefined" && deleted_user.roomIdx!=null && deleted_user.roomIdx.length == 50){
                (async function() {
                    await knex('pb_room')
                        .where('roomIdx', deleted_user.roomIdx)
                        .update({
                            members: getUsersByRoomIdx(deleted_user.roomIdx)
                        })
                })()
            }
        }
    })
    client.on("send",(data,callback) => {
        if(data.header.type == "CREATE"){
            var obj = {};
            obj.header = {type:"NOTICE"};
            obj.body = data.body;
            obj.body.type = "CREATECHATROOMMSG";
            public.emit("receive",obj);
        }
        else if(data.header.type == "ADMINCMD"){
            if(data.body.cmd == "freezeOn" || data.body.cmd == "freezeOff" ){
                roomio.to(data.body.roomIdx).emit("receive",{header:{type:"CMDMSG"},body:{cmd:data.body.cmd}});
            }
            else if(data.body.cmd == "call"){
                roomio.to(data.body.roomIdx).emit("receive",{header:{type:"CMDMSG"},body:{cmd:"call"}});
            }

            else if(data.body.cmd == "modifyRoom"){
                roomio.to(data.body.roomIdx).emit("receive",{header:{type:"NOTICE"},body:{type:"MODIFYROOM",roomTitle:data.body.roomTitle,roomDesc:data.body.roomDesc,roomPublic:data.body.roomPublic,roomIdx:data.body.roomIdx}});
            }
            else if(data.body.cmd == "closeRoom"){
                refreshChatByRoomIdx(data.body.roomIdx)
                roomio.to(data.body.roomIdx).emit("receive",{header:{type:"NOTICE"},body:{type:"CLOSEROOM"}});
            }
            else if(data.body.cmd == "muteOn" || data.body.cmd == "muteOff"){
                let result = setUserMuteById(data.body.cmd,data.body.tuseridKey,data.body.roomIdx)
                if( typeof result !="undefined" && result !=null && result != "")
                    roomio.to(data.body.roomIdx).emit("receive",{header:{type:"CMDMSG"},body:{cmd:data.body.cmd,tuseridKey:data.body.tuseridKey,tnickname:result}});
            }
            else if(data.body.cmd == "kickOn"){
                let user = getUser(data.body.tuseridKey)
                if(typeof  user !="undefined")
                    roomio.to(data.body.roomIdx).emit("receive",{header:{type:"CMDMSG"},body:{cmd:"kickOn",tuseridKey:data.body.tuseridKey,tnickname:user.nickname}});
            }

            else if(data.body.cmd == "managerOn" || data.body.cmd == "managerOff"){
                let result = setUserManageById(data.body.cmd,data.body.tuseridKey,data.body.roomIdx)
                if( typeof result !="undefined" && result !=null && result != "")
                  roomio.to(data.body.roomIdx).emit("receive",{header:{type:"CMDMSG"},body:{cmd:data.body.cmd,tuseridKey:data.body.tuseridKey,tnickname:result}});
            }

            else if(data.body.cmd == "fixMemberOn" || data.body.cmd == "fixMemberOff"){
                let result = setFixManageById(data.body.cmd,data.body.tuseridKey,data.body.roomIdx)
                roomio.to(data.body.roomIdx).emit("receive",{header:{type:"CMDMSG"},body:{cmd:data.body.cmd,tuseridKey:data.body.tuseridKey,tnickname:result}});
            }

            else{
                data.body.cmd = "powerball-pick";
                roomio.to(data.body.roomIdx).emit("receive",{header:{type:"CMDMSG"},body:data.body})
            }

        }

        else if(data.header.type == "refreshMsg"){
            deleteMsgByRoomIdx(data.body.roomIdx)
            roomio.to(data.body.roomIdx).emit("receive",{header:{type:"CMDMSG"},body:{cmd:"clear"}});
        }
        else if(data.header.type == "USERCMD"){
            let type = 1;
            let user = getUserByRoomIdxAndClientId(client.id,data.body.roomIdx);
            if(typeof user != "undefined"){
                roomio.to(data.body.roomIdx).emit("receive",{header:{type:"CMDMSG"},body:{cmd:"recomChatRoom",level:user.level,nickname:user.nickname,userIdKey:user.userIdKey}})
            }
        }
        else if(data.header.type == "GIFT"){
            let t_user = getUser(data.body.tuseridKey)

            if(typeof  t_user !="undefined"){
                let user = getUserByRoomIdxAndClientId(client.id,data.body.roomIdx);
                if(typeof user != "undefined"){
                    roomio.to(data.body.roomIdx).emit("receive",{header:{type:"CMDMSG"},body:{cmd:"gift",cnt:data.body.cnt,type:data.body.type,tnickname:t_user.nickname,nickname: user.nickname}});
                }
            }
        }

        else
            checkInPacket(data,client,roomio);
    })
    client.on("receive",(data,callback) =>{
        client.to(data.body.roomIdx).emit("receive",data);

    })
});

let pick = io.of('/pick');
pick.on("connection",(client) => {
    client.on('disconnect', () => {

    })
    client.on("user_pick",(data,callback) => {
        var obj = {};
        obj.header = {type:"notice_pick"};
        obj.body = {type:"pick",pick:data.body.cmd};
        public.emit("receive",obj);
        roomio.emit("receive",obj);
    })
});

let item_socket = io.of('/item');
item_socket.on("connection",(client) => {
    client.on('disconnect', () => {

    })
    client.on("send",(data,callback) => {
      setUserItem(data)
    })
});

let prefix_socket = io.of('/prefix');
prefix_socket.on("connection",(client) => {
    client.on('disconnect', () => {
      setAdminConfig("","","")
    })
    client.on("send",(data,callback) => {
      prefix_socket.emit("receive",data);
    })
    client.on("init",(data,callback)=>{
      adminRealtime(data,client,prefix_socket);
      setAdminConfig(client,prefix_socket,data)
      console.log("ddf")
    })
    client.on("adminsend",(data,callback)=>{
      if(data.header.type == "ADMINCMD"){
          if(data.body.roomIdx == "channel1"){
            if(data.body.cmd == "muteOn" || data.body.cmd == "muteOnTime1" || data.body.cmd == "muteOnTime" || data.body.cmd == "muteOff"){
              let result = setUserMuteById(data.body.bytime,data.body.tuseridKey,data.body.roomIdx)
              if( typeof result !="undefined" && result !=null && result != "")
                  public.to(data.body.roomIdx).emit("receive",{header:{type:"CMDMSG"},body:{cmd:data.body.cmd,tuseridKey:data.body.tuseridKey,tnickname:result,msg:result+" "+data.body.cmd}});
            }
            if(data.body.cmd == "banipOn" || data.body.cmd == "banipOff"){
              let user = getUserFromIdAndRoomIdx(data.body.tuseridKey,"channel1")
              if(typeof  user !="undefined")
                public.to(data.body.roomIdx).emit("receive",{header:{type:"CMDMSG"},body:{cmd:data.body.cmd,tuseridKey:data.body.tuseridKey,tnickname:user.nickname}});
            }

            if(data.body.cmd == "foreverstop"){
              let user = getUser(data.body.tuseridKey)
              if(typeof  user !="undefined" && user !=null)
                public.to(data.body.roomIdx).emit("receive",{header:{type:"CMDMSG"},body:{cmd:data.body.cmd,tuseridKey:data.body.tuseridKey,tnickname:user.nickname}});
            }
          }
          if(data.body.roomIdx.length == 50){
            if(data.body.cmd == "muteOn" || data.body.cmd == "muteOff"){
              let result = setUserMuteById(data.body.cmd,data.body.tuseridKey,data.body.roomIdx)
              if( typeof result !="undefined" && result !=null && result != "")
                  roomio.to(data.body.roomIdx).emit("receive",{header:{type:"CMDMSG"},body:{cmd:data.body.cmd,tuseridKey:data.body.tuseridKey,tnickname:result}});
            }
            if(data.body.cmd == "closeRoom"){
                refreshChatByRoomIdx(data.body.roomIdx)
                roomio.to(data.body.roomIdx).emit("receive",{header:{type:"NOTICE"},body:{type:"CLOSEROOM"}});
            }
            if(data.body.cmd == "kickOn"){
              let user = getUser(data.body.tuseridKey)
              if(typeof  user !="undefined")
                  roomio.to(data.body.roomIdx).emit("receive",{header:{type:"CMDMSG"},body:{cmd:"kickOn",tuseridKey:data.body.tuseridKey,tnickname:user.nickname}});
            }
            if(data.body.cmd == "foreverstop"){
              public.to("channel1").emit("receive",{header:{type:"CMDMSG"},body:{cmd:data.body.cmd,tuseridKey:data.body.tuseridKey}});
            }
          }
      }
    })
    client.on("closeroom",(data,callback)=>{
      refreshChatByRoomIdx(data)
      roomio.to(data).emit("receive",{header:{type:"NOTICE"},body:{type:"CLOSEROOM"}});
    })
});

module.exports = {
    public_msg,
    private_msg
}
