const {knex} = require('../server')
const {User} = require('../classes/users')
const {Msg} = require('../classes/msg')

let listUsers = new User();
let listMsg = new Msg();
function createMessage(id, nickname,item,level,mark,msg,sex,winFixCnt,userType){
    return {
        id,
        nickname,
        item,
        level,
        mark,
        msg,
        sex,
        winFixCnt,
        userType
    }
}
function checkInPacket(data,obj,io){
    let return_obj= {};
    let duplicated = 0;
    switch (data.header.type){
        case "login":
            if(data.body.cmd =="LOGIN"){
                let token  = "";
                if(data.body.userToken.trim() == "")
                    token = "NULL";
                else
                    token  = data.body.userToken.trim()
                let l = "";
                if(data.body.roomIdx == "channel1")
                    l = "channel1";
                else
                    l="lobby";
                let u = listUsers.getUserFromIdAndRoomIdx(token,l);

                if(typeof u !== 'undefined')
                {
                    if(data.body.roomIdx == u.roomIdx
                        && token == u.id){
                        if (typeof io.sockets.get(u.clientId) != 'undefined') {
                            io.sockets.get(u.clientId).emit("receive",{header:{type:"LOGIN"},body:{cmd:"ERROR",type:"DUPLICATE"}});
                            io.sockets.get(u.clientId).disconnect();
                        }
                        listUsers.deleteUserByClientId(u.clientId)
                        duplicated = 1;
                    }
                }

               if(data.body.roomIdx == "channel1"){
                   try{
                       (async function() {
                           let date  = new Date();
                           obj.join(data.body.roomIdx)
                           let user = await knex("pb_users").where("pb_users.userIdKey",token);
                           if(user.length ==0 || typeof  user == 'undefined') {
                               listUsers.addUser(token, '', '', '', '', 0, obj.id, data.body.roomIdx,date.getTime(),"","","channel1")
                               return_obj = {header: {type: "ERROR"}, body: {type: "NOT_LOGIN",connectList:listUsers.getUsersByRoomIdx(data.body.roomIdx),msgList:listMsg.getMsgRoomIdx(data.body.roomIdx)}};
                           }
                           else {
                               listUsers.addUser(token, user[0]["name"], user[0]["level"], user[0]["nickname"], user[0]["sex"], 0, obj.id, data.body.roomIdx,date.getTime(),"","","channel1")
                               return_obj = {header:{type:"INITMSG"},body:{roomIdx:data.body.roomIdx,freezeOnOff:"off",fixNoticeOnOff:"off",fixNoticeMsg:"",connectList:listUsers.getUsersByRoomIdx(data.body.roomIdx),msgList:listMsg.getMsgRoomIdx(data.body.roomIdx)}};
                               obj.to(data.body.roomIdx).emit("receive",{header:{type:"ListUser"},body:{users:listUsers.getUserByClientId(obj.id)}})
                           }
                           obj.emit("receive",return_obj);
                       })()
                   }catch(e){
                       return_obj = {header:{type:"ERROR"},body:{type:"NOT_LOGIN"}};
                       obj.emit("receive",return_obj);
                   }
               }
               else if(data.body.roomIdx == "lobby"){
                   try{
                       (async function() {
                           let date  = new Date();
                           obj.join(data.body.roomIdx)
                           let user = await knex("pb_users").where("pb_users.userIdKey",token);
                           if(user.length ==0 || typeof  user == 'undefined') {
                               listUsers.addUser(token, '', '', '', '', 0, obj.id, data.body.roomIdx,date.getTime(),"","","lobby")
                               return_obj = {header: {type: "ERROR"}, body: {type: "NOT_LOGIN"}};
                               obj.emit("receive",return_obj);
                           }
                           else {
                               let profile_img = "https://simg.powerballgame.co.kr/images/profile.png"
                               if(user[0]["image"] != "" && user[0]["image"] !==null)
                                   profile_img = user[0]["image"]
                               listUsers.addUser(token, user[0]["name"], user[0]["level"], user[0]["nickname"], user[0]["sex"], 0, obj.id, data.body.roomIdx,date.getTime(),"","","lobby",profile_img,user[0]["today_word"])
                               obj.to(data.body.roomIdx).emit("receive",{header:{type:"ListUser"},body:{users:listUsers.getUserByClientId(obj.id)}})
                               obj.emit("receive",{header:{type:"INITMSG"},body:{users:listUsers.getUsersByRoomIdx(data.body.roomIdx),connector:getCountRoom()}})
                           }
                       })()
                   }catch(e){
                       return_obj = {header:{type:"ERROR"},body:{type:"NOT_LOGIN"}};
                       obj.emit("receive",return_obj);
                   }
               }
               if(data.body.roomIdx.length == 50){
                   try{
                       (async function() {
                           let date  = new Date();
                           obj.join(data.body.roomIdx)
                           let user = await knex("pb_users").where("pb_users.userIdKey",token);
                           if(user.length ==0 || typeof  user == 'undefined') {
                               listUsers.addUser(token, '', '', '', '', 0, obj.id, data.body.roomIdx,date.getTime(),"","","lobby")
                               return_obj = {header: {type: "ERROR"}, body: {type: "NOT_LOGIN"}};
                               obj.emit("receive",return_obj);
                           }
                           else {
                                let room = await knex("pb_room").where("pb_room.roomIdx",data.body.roomIdx);
                                let userType = 5;
                                if(await room != 'undefined'){
                                    if( room[0]['super'] == token){
                                        userType = 1;
                                    }
                                    if(room[0]['manager'] !=null && room[0]['manager'].includes(token)){
                                        userType = 2;
                                    }

                                    let profile_img = "https://simg.powerballgame.co.kr/images/profile.png"
                                    if(user[0]["image"] != "" && user[0]["image"] !==null)
                                        profile_img = user[0]["image"]
                                    listUsers.addUser(token, user[0]["name"], user[0]["level"], user[0]["nickname"], user[0]["sex"], 0, obj.id, data.body.roomIdx,date.getTime(),"","","lobby",profile_img,user[0]["today_word"],userType)
                                    obj.to(data.body.roomIdx).emit("receive",{header:{type:"ListUser"},body:{users:listUsers.getUserByClientId(obj.id)}})
                                    obj.emit("receive",{header:{type:"INIT"},body:{freezeOnOff:room[0]['frozen'],users:listUsers.getUsersByRoomIdx(data.body.roomIdx),msgList:listMsg.getMsgRoomIdx(data.body.roomIdx)}})
                                }
                                else
                                {
                                    return_obj = {header: {type: "ERROR"}, body: {type: "NOT_ROOM"}};
                                    obj.emit("receive",return_obj);
                                }
                           }
                       })()
                   }catch(e){
                       return_obj = {header:{type:"ERROR"},body:{type:"NOT_LOGIN"}};
                       obj.emit("receive",return_obj);
                   }
               }
            }
            break;

        case "MSG":
            let user = listUsers.getUserByClientId(obj.id);
            if(typeof user == 'undefined'){
                return_obj = {header:{type:"ERROR"},body:{type:"NOT_LOGIN"}};
                obj.emit("receive",return_obj)
            }
            else{
                return_obj = {header:{type:"MSG"},body:createMessage(user.id,user.nickname,user.item,user.level,user.mark,data.body.msg,user.sex,user.winFixCnt,user.userType)};
                if(listMsg.getMsgLengthFromRoomIdx(data.body.roomIdx) >= 30){
                    let msg = listMsg.getFirstMsgByRoomIdx(data.body.roomIdx);
                    listMsg.deleteMsgByUserToken(msg.id);
                }
                listMsg.createMsg(user.id,"",user.level,"",data.body.msg,user.nickname,user.sex,user.winFixCnt,obj.id,data.body.roomIdx,user.userType);
                io.to(data.body.roomIdx).emit("receive",return_obj)
            }

            break;
        default:
            return_obj = {header:{type:"ERROR"},body:{type:"AUTHKEY_NOTMATCHED"}};
            obj.emit("receive",return_obj);
            break;
    }
}

function deleteUserById(id){
    listUsers.deleteUser(id);
}

function deleteMembersFromTable(roomIdx){
    (async function() {
        await knex('pb_room').where("roomIdx",roomIdx).update("members",listUsers.getUsersByRoomIdx(roomIdx).length);
    })
}

function deleteUserByClientId(id){
    let user = listUsers.getUserByClientId(id);
    listUsers.deleteUserByClientId(id);
    return user;
}

function refreshChatByRoomIdx(roomIdx){
    listUsers.deleteUserByRoomIdx(roomIdx);
    listMsg.deleteMsgByRoomIdx(roomIdx);
}

function getUsers(){
    return listUsers.getUsers();
}

function getCountRoom(){
    var res = {};
    listUsers.getUserFromOnlyRoom().forEach(function(v) {
        res[v.roomIdx] = (res[v.roomIdx] || 0) + 1;
    })
    return res;
}

function getUserByRoomIdxAndClientId(clientId,roomIdx){
    let user = listUsers.getUserFromClientIdAndRoomIdx(clientId,roomIdx)
    return user;
}

function deleteMsgByRoomIdx(roomIdx){
    listMsg.deleteMsgByRoomIdx(roomIdx);
}

function deleteCharRooom(roomIdx){
    listUsers.deleteUserByRoomIdx(roomIdx)
    listMsg.deleteMsgByRoomIdx(roomIdx)
}

function getUserFromIdAndRoomIdx(id,roomIdx="lobby"){
    return listUsers.getUserFromIdAndRoomIdx(id,roomIdx);
}

module.exports = {
    createMessage,
    checkInPacket,
    deleteUserById,
    deleteUserByClientId,
    getUsers,
    deleteMembersFromTable,
    refreshChatByRoomIdx,
    getUserByRoomIdxAndClientId,
    deleteMsgByRoomIdx,
    deleteCharRooom,
    getUserFromIdAndRoomIdx
}
