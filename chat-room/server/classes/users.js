
class User {
    constructor(){
        this.users = []
    }

    addUser(id, name,level,nickname,sex,winFixCnt,clientId = "",roomIdx="",time=0,mark="",item="",lobby="",image="",today="",userType=0,mute="muteOff",mute1="muteOff",bytime=""){
        this.users.push({id, name,level,nickname,sex,winFixCnt,clientId,roomIdx,time,mark,item,lobby,image,today,userType,mute,mute1,bytime})
        return this.users
    }
    getUser(id){
        return this.users.filter(user => user.id === id)[0]
    }
    getUserFromIdAndRoomIdx(id,lobby){
        return this.users.filter(user => user.id === id && user.lobby === lobby)[0]
    }

    getUserByIdAndRoomIdx(id,roomIdx){
        return this.users.filter(user => user.id === id && user.roomIdx === roomIdx)[0]
    }

    getUserFromClientIdAndRoomIdx(clientId,roomIdx){
        return this.users.filter(user => user.clientId === clientId && user.roomIdx === roomIdx)[0]
    }

    getUserByClientId(clientId){
        return this.users.filter(user => user.id !== 'NULL' && user.clientId === clientId)[0]
    }

    getUserFromOnlyRoom(){
        return this.users.filter(user => user.roomIdx != 'channel1' && user.roomIdx != "lobby")
    }

    getUsersByRoomIdx(roomIdx){
        return this.users.filter(user => user.roomIdx === roomIdx)
    }

    getUsers(){
        return this.users
    }

    deleteUser(id){
        let deletedUser = this.getUser(id)
        this.users = this.users.filter((user) => user.id != id)
        return deletedUser
    }

    deleteUserByClientId(clientId){
        this.users = this.users.filter((user) => user.clientId != clientId)
    }

    deleteUserByRoomIdx(roomIdx){
        this.users = this.users.filter((user) => user.roomIdx != roomIdx)
    }

    setUserMuteById(state,id,roomIdx){
        if(roomIdx != ""){
            var user = this.users.filter(user => user.roomIdx === roomIdx && user.id === id)[0]
        }
        else
            var user = this.users.filter(user => user.id === id)[0]
        if(typeof user !="undefined"){
           this.users = this.users.filter((item) => {
               if(roomIdx != "" && item.roomIdx === roomIdx && item.id === id){
                   item.mute = state;
               }
               if(roomIdx == "" && item.id === id){
                    item.mute1 = state.mute1
                    item.bytime = state.bytime
               }
               return item;
           });
           return user.nickname;
        }
        return "";
    }

    setUserManageById(state,id,roomIdx){
        var user = this.users.filter(user => user.roomIdx === roomIdx && user.id === id)[0]
        if(typeof user !="undefined"){
            this.users = this.users.filter((item) => {
                if(item.roomIdx === roomIdx && item.id === id){
                    if(state == "managerOn"){
                        if(item.userType !=1)
                            item.userType = 2;
                    }
                    else{
                        if(item.userType !=1)
                            item.userType = 5;
                    }
                }
                return item;
            });
            return user.nickname;
        }
        return "";
    }
}

module.exports = {
    User
}
