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
    getUsersByRoomIdx

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
            presult.emit("receive",data)
        }
        else{
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
                if(result != "")
                    roomio.to(data.body.roomIdx).emit("receive",{header:{type:"CMDMSG"},body:{cmd:data.body.cmd,tuseridKey:data.body.tuseridKey,tnickname:result}});
            }
            else if(data.body.cmd == "kickOn"){
                let user = getUserFromIdAndRoomIdx(data.body.tuseridKey)
                if(typeof  user !="undefined")
                    roomio.to(data.body.roomIdx).emit("receive",{header:{type:"CMDMSG"},body:{cmd:"kickOn",tuseridKey:data.body.tuseridKey,tnickname:user.nickname}});
            }

            else if(data.body.cmd == "managerOn" || data.body.cmd == "managerOff"){
                let result = setUserManageById(data.body.cmd,data.body.tuseridKey,data.body.roomIdx)
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
            let t_user = getUserFromIdAndRoomIdx(data.body.tuseridKey)

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

module.exports = {
    public_msg,
    private_msg
}
