const {knex} = require('../server')
const {User} = require('../classes/users')

let listUsers = new User();
function createMessage(name, message){
    return {
        name,
        message,
        date: new Date().getTime()
    }
}

function checkInPacket(data,obj){
    let return_obj= {};
    switch (data.header.type){
        case "login":
            console.log(data.body.userToken.trim());
            console.log(data.body.roomIdx.trim());

            if(data.body.cmd =="LOGIN"){
                if(data.body.userToken.trim() == "" || typeof data.body.userToken == undefined)
                    return_obj = {header:{type:"ERROR"},body:{type:"NOT_LOGIN"}};
                else{
                    let u = listUsers.getUserFromIdAndRoomIdx(data.body.userToken.trim(),data.body.roomIdx);
                    if(typeof u !== 'undefined')
                    {
                        if(data.body.roomIdx == u.roomIdx
                            && data.body.userToken == u.id){
                            // if(obj.sockets.sockets[u.clientId])
                            //     obj.sockets.sockets[u.clientId].disconnect();
                            listUsers.deleteUserByClientId(u.clientId)
                            return_obj = {header:{type:"LOGIN"},body:{cmd:"ERROR",type:"DUPLICATE"}};
                        }
                    }

                    try{
                        (async function() {
                            let user = await knex("pb_users").where("pb_users.api_token",data.body.userToken.trim());
                            if(user.length ==0 || typeof  user == undefined)
                                return_obj = {header:{type:"ERROR"},body:{type:"NOT_LOGIN"}};
                            else
                                listUsers.addUser(data.body.userToken.trim(),user[0]["name"],user[0]["level"],user[0]["nickname"],user[0]["sex"],0,obj.id,data.body.roomIdx)
                        })()
                    }catch(e){
                        console.log("error : "+e)
                    }
                }
            }
            break;
        default:
            return_obj = {header:{type:"ERROR"},body:{type:"AUTHKEY_NOTMATCHED"}};
            break;
    }
    obj.emit("receive",return_obj);
}

function deleteUserById(id){
    listUsers.deleteUser(id);
}

function deleteUserByClientId(id){
    listUsers.deleteUserByClientId(id);
}

module.exports = {
    createMessage,
    checkInPacket,
    deleteUserById,
    deleteUserByClientId
}
