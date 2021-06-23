const {knex} = require('../server')
const {User} = require('../classes/users')
const {Msg} = require('../classes/msg')
const moment = require('moment');
const strtotime = require('strtotime');
const { v4: uuidv4 } = require('uuid');
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
            let mute = "muteOff";
            let mute1 = "muteOff";
            let bytime=  "";
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
                let u = listUsers.getUserFromIdAndRoomIdx(token,l,obj.handshake.address);
                if(u.length > 0)
                {
                    u.forEach(individual => {
                      if (typeof io.sockets.get(individual.clientId) != 'undefined') {
                          let logout = 1;
                          if(token == individual.id && individual.ip == obj.handshake.address && l=="channel1" && individual.lobby == "channel1"){
                            logout = 0;
                          }
                          io.sockets.get(individual.clientId).emit("receive",{header:{type:"LOGIN"},body:{cmd:"ERROR",type:"DUPLICATE",logout:logout}});
                          io.sockets.get(individual.clientId).disconnect();
                      }
                      listUsers.deleteUserByClientId(individual.clientId)
                    });
                    // console.log("ss")
                    // if(data.body.roomIdx == u.roomIdx
                    //     && ( (token == u.id && u.id !="NULL" && u.id.trim() != "" ) || u.ip == obj.handshake.address)){
                    //       if (typeof io.sockets.get(individual.clientId) != 'undefined') {
                    //           io.sockets.get(individual.clientId).emit("receive",{header:{type:"LOGIN"},body:{cmd:"ERROR",type:"DUPLICATE"}});
                    //           io.sockets.get(individual.clientId).disconnect();
                    //       }
                    //     listUsers.deleteUserByClientId(u.clientId)
                    //     duplicated = 1;
                    // }
                }

               if(data.body.roomIdx == "channel1"){

                   try{
                       (async function() {
                           obj.join(data.body.roomIdx)
                           let user = await knex("pb_users")
                               .select( 'pb_users.*',
                                                knex.raw('GROUP_CONCAT(CONCAT(pb_item_use.market_id , "%%%" , pb_item_use.terms2)  SEPARATOR ",") as ??', ['markets'])
                                        )
                               .leftJoin('pb_item_use', 'pb_users.userId', 'pb_item_use.userId')
                               .where("pb_users.userIdKey",token);

                           if(typeof user[0]["userId"] == "undefined" || user[0]["userId"] == null || user.length ==0 || typeof  user == 'undefined') {
                               let date  = new Date();
                               listUsers.addUser("null-"+uuidv4(), '', '', '', '', 0, obj.id, data.body.roomIdx,date.getTime(),"","","channel1","/assets/images/mine/profile.png","",0,"muteOff","muteOff","",obj.handshake.address)
                               return_obj = {header: {type: "ERROR"}, body: {type: "NOT_LOGIN",connectList:listUsers.getUsersByRoomIdx(data.body.roomIdx),msgList:listMsg.getMsgRoomIdx(data.body.roomIdx)}};
                           }
                           else {
                               let item = new Array();
                               let winning_history = user[0]["winning_history"];
                               let current_win = 0;
                               if(winning_history !=null && winning_history.trim() != ""){
                                   current_win  = typeof(JSON.parse(winning_history)["current_win"]["p"]) != "undefined" ? JSON.parse(winning_history)["current_win"]["p"] : 0;
                               }
                               var date = new Date();
                               if(typeof user[0]["markets"] !="undefined" && user[0]["markets"] !=null &&  user[0]["markets"].trim() != ""){
                                   let item_split = user[0]["markets"].split(",");
                                   if(item_split.length > 0){
                                       for(let index = 0 ; index < item_split.length;index++){
                                           let terms2 = item_split[index].split("%%%")[1];
                                           if(strtotime(terms2) <= strtotime(moment().format('yyyy-MM-DD hh:mm:ss')))
                                               continue;
                                           if(item_split[index].split("%%%")[0] == "FAMILY_NICKNAME_LICENSE" && user[0]["familynickname"].split("%%%")[0].trim() != "")
                                               item.push("familyNick_"+user[0]["familynickname"].trim());
                                           if(item_split[index].split("%%%")[0] == "SUPER_CHAT_LICENSE" || item_split[index].split("%%%")[0] == "SUPER_CHAT_LICENSE_BREAD")
                                               item.push("superChat");
                                           if(item_split[index].split("%%%")[0] == "ORDER_HONOR_30" && date_diff(user[0]["win_date"]) <= 7)
                                           {
                                               if(user[0]["badge"] >= 20)
                                                   item.push("badge20");
                                               if(user[0]["badge"] >= 15)
                                                   item.push("badge15");
                                               if(user[0]["badge"] >= 10)
                                                   item.push("badge10");
                                               if(user[0]["badge"] >= 5)
                                                   item.push("badge5");
                                           }
                                           if(item_split[index].split("%%%")[0] == "SUPER_HIGH_LEVEL_UP")
                                               item.push("levelupx4");
                                           if(item_split[index].split("%%%")[0] == "HIGH_LEVEL_UP")
                                               item.push("levelupx2");

                                       }
                                   }
                               }

                               listUsers.addUser(token, user[0]["name"], user[0]["level"], user[0]["nickname"], user[0]["sex"], current_win, obj.id, data.body.roomIdx,date.getTime(),"",item.join("#::#"),"channel1","","",0,"muteOff","muteOff","",obj.handshake.address)
                               return_obj = {header:{type:"INITMSG"},body:{roomIdx:data.body.roomIdx,freezeOnOff:"off",fixNoticeOnOff:"off",fixNoticeMsg:"",connectList:listUsers.getUsersByRoomIdx(data.body.roomIdx),msgList:listMsg.getMsgRoomIdx(data.body.roomIdx)}};

                           }
                           obj.to(data.body.roomIdx).emit("receive",{header:{type:"ListUser"},body:{users:listUsers.getUserByClientId(obj.id)}})
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
                           console.log(user)
                           let profile_img = "/assets/images/mine/profile.png"
                           let any_token = uuidv4();
                           if(user.length ==0 || token == null || token == "" || typeof user[0]["userId"] == "undefined" || user[0]["userId"] == null ||  typeof  user == 'undefined') {
                               listUsers.addUser("null-"+any_token, '', '00', any_token.substring(0,4)+"..훈련병", '', 0, obj.id, data.body.roomIdx,date.getTime(),"","","lobby",profile_img,"",0,"muteOff","muteOff","",obj.handshake.address)
                               console.log(listUsers.getUsersByRoomIdx(data.body.roomIdx))
                               // return_obj = {header: {type: "ERROR"}, body: {type: "NOT_LOGIN"}};
                               // obj.emit("receive",return_obj);
                               obj.to(data.body.roomIdx).emit("receive",{header:{type:"ListUser"},body:{users:listUsers.getUserByClientId(obj.id)}})
                               obj.emit("receive",{header:{type:"INITMSG"},body:{users:listUsers.getUsersByRoomIdx(data.body.roomIdx),connector:getCountRoom()}})
                           }
                           else {

                               if(user[0]["image"] != "" && user[0]["image"] !==null)
                                   profile_img = user[0]["image"]
                               listUsers.addUser(token, user[0]["name"], user[0]["level"], user[0]["nickname"], user[0]["sex"], 0, obj.id, data.body.roomIdx,date.getTime(),"","","lobby",profile_img,user[0]["today_word"],0,"muteOff","muteOff","",obj.handshake.address)
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
                           if(typeof user[0]["userId"] == "undefined" || user[0]["userId"] == null || user.length ==0 || typeof  user == 'undefined') {
                               listUsers.addUser("null-"+uuidv4(), '', '', '', '', 0, obj.id, data.body.roomIdx,date.getTime(),"","","lobby","",0,"muteOff","muteOff","",obj.handshake.address)
                               return_obj = {header: {type: "ERROR"}, body: {type: "NOT_LOGIN"}};
                               obj.emit("receive",return_obj);
                           }
                           else {
                                let room = await knex("pb_room",knex.raw('pb_users.fixed as ??',["fixed"]))
                                    .where("pb_room.roomIdx",data.body.roomIdx)
                                    .leftJoin("pb_users","pb_room.super","pb_users.userIdKey");
                                let userType = 5;
                                if(await room != 'undefined'){

                                    if( room[0]['super'] == token){
                                        userType = 1;
                                    }

                                    if(room[0]['manager'] !=null && room[0]['manager'].includes(token)){
                                        userType = 2;
                                    }

                                    if(room[0]['fixed'] !=null && room[0]['fixed'].includes(token)){
                                        if(userType == 2)
                                            userType =3;
                                        else userType = 4;
                                    }

                                    if(typeof room[0]["mute"] !="undefined" && room[0]["mute"] != "" && room[0]["mute"] !=null && room[0]["mute"].includes(user[0]["userIdKey"]))
                                    {
                                        mute = "muteOn";
                                    }
                                    let profile_img = "/assets/images/mine/profile.png"
                                    if(user[0]["image"] != "" && user[0]["image"] !==null)
                                        profile_img = user[0]["image"];
                                    listUsers.addUser(token, user[0]["name"], user[0]["level"], user[0]["nickname"], user[0]["sex"], 0, obj.id, data.body.roomIdx,date.getTime(),"","","lobby",profile_img,user[0]["today_word"],userType,mute,"muteOff","",obj.handshake.address)
                                    obj.to(data.body.roomIdx).emit("receive",{header:{type:"ListUser"},body:{users:listUsers.getUserByClientId(obj.id)}})
                                    obj.emit("receive",{header:{type:"INIT"},body:{freezeOnOff:room[0]['frozen'],users:listUsers.getUsersByRoomIdx(data.body.roomIdx),msgList:listMsg.getMsgRoomIdx(data.body.roomIdx)}})
                                    await knex('pb_room')
                                        .where('roomIdx', data.body.roomIdx)
                                        .update({
                                            members: listUsers.getUsersByRoomIdx(data.body.roomIdx).length,
                                        })
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
            if(typeof user == 'undefined' || user.id.includes("null-")){
                return_obj = {header:{type:"ERROR"},body:{type:"NOT_LOGIN"}};
                obj.emit("receive",return_obj)
            }
            else{
                if(user.mute == "muteOn"){
                    obj.emit("receive",{header:{type:"NOTICE"},body:{type:"MUTEMSG"}})
                }
                else{
                    return_obj = {header:{type:"MSG"},body:createMessage(user.id,user.nickname,user.item,user.level,user.mark,data.body.msg,user.sex,user.winFixCnt,user.userType)};
                    if(listMsg.getMsgLengthFromRoomIdx(data.body.roomIdx) >= 30){
                        let msg = listMsg.getFirstMsgByRoomIdx(data.body.roomIdx);
                        listMsg.deleteMsgByUserToken(msg.id);
                    }
                    listMsg.createMsg(user.id,user.item,user.level,"",data.body.msg,user.nickname,user.sex,user.winFixCnt,obj.id,data.body.roomIdx,user.userType);
                    io.to(data.body.roomIdx).emit("receive",return_obj)
                }

            }

            break;
        case "MEMO":
            console.log(data.body.tuseridKey.length)
            if(data.body.tuseridKey.length > 0)
                for(let i =0; i < data.body.tuseridKey.length; i++){
                    let user = listUsers.getUser(data.body.tuseridKey[i]);
                    if(typeof user !="undefined"){
                        if (typeof io.sockets.get(user.clientId) != 'undefined') {
                            io.sockets.get(user.clientId).emit("receive",{header:{type:"MEMO"}})
                        }
                    }
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

function getUsersByRoomIdx(roomIdx){
    return listUsers.getUsersByRoomIdx(roomIdx).length
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

function setUserMuteById(state,id,roomIdx){
    return listUsers.setUserMuteById(state,id,roomIdx)
}

function setUserManageById(state,id,roomIdx){
    return listUsers.setUserManageById(state,id,roomIdx)
}

function setFixManageById(state,id,roomIdx){
    return listUsers.setFixManageById(state,id,roomIdx)
}

function setUserItem(data){
  listUsers.setUserItem(data)
}


function date_diff(date){
    if(date != null && typeof date !="undefined"){
        var date1 = new Date(date);
        var date2 = new Date();
        var diffTime = Math.abs(date2 - date1);
        var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    }
    else{
        var diffDays = 100;
    }
    return diffDays;
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
    getUserFromIdAndRoomIdx,
    setUserMuteById,
    setUserManageById,
    setFixManageById,
    getUsersByRoomIdx,
    setUserItem
}
