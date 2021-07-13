
class User {
    constructor(){
        this.users = []
    }

    addUser(id, name,level,nickname,sex,winFixCnt,clientId = "",roomIdx="",time=0,mark="",item="",lobby="",image="",today="",userType=0,mute="muteOff",mute1="muteOff",bytime="0",ip){
        this.users.push({id, name,level,nickname,sex,winFixCnt,clientId,roomIdx,time,mark,item,lobby,image,today,userType,mute,mute1,bytime,ip})
        return this.users
    }
    getUser(id){
        return this.users.filter(user => user.id === id)[0]
    }
    getUserFromIdAndRoomIdx(id,lobby,ip= ""){
        if(ip == "")
          return this.users.filter(user => user.id === id && user.lobby === lobby)[0]
        if(ip != ""){
          return this.users.filter(user =>{
            if( (user.id === id && user.lobby === lobby) ||
                (user.ip !== ip && user.id === id) ||
                (user.id !== id && user.ip ===ip))
            {
                  return user;
            }
          })
        }
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
               if(roomIdx != "" && roomIdx!="channel1" && item.roomIdx === roomIdx && item.id === id){
                   item.mute = state;
               }
               if((roomIdx == "" || roomIdx == "channel1")  && item.id === id){
                    item.bytime = state
               }
               return item;
           });
           return user.nickname;
        }
        return "";
    }

     setUserItem(data){
      var user = this.users.filter(user => user.id === data.userIdKey)[0];
      console.log(data.userIdKey)
      if(typeof user !="undefined"){
        this.users = this.users.filter((item) => {
            if(item.id === data.userIdKey){
                if(data.type == "family"){
                  if(item.item.trim() == "")
                    item.item = "familyNick_"+data.content
                  else {
                    item.item += "#::#" + "familyNick_"+data.content;
                  }
                }
                if(data.type == "super"){
                  if(item.item.trim() == "")
                    item.item = "superChat"
                  else {
                    item.item += "#::#" + "superChat";
                  }
                }
            }
            return item;
        });
      }
    }

    setUserManageById(state,id,roomIdx){
        var user = this.users.filter(user => user.roomIdx === roomIdx && user.id === id)[0]
        if(typeof user !="undefined"){
            this.users = this.users.filter((item) => {
                if(item.roomIdx === roomIdx && item.id === id){
                    if(state == "managerOn"){
                        let utype = 2; // 멤버만
                        if(item.userType !=1 && item.userType ==4)
                            utype = 3; // // 멤버,고정
                        item.userType  = utype;
                    }
                    else{
                        let utype = 5;
                        if(item.userType !=1 && item.userType == 3)
                            utype = 4;
                        item.userType = utype;
                    }
                }
                return item;
            });
            return user.nickname;
        }
        return "";
    }

    setFixManageById(state,id,roomIdx){
        var user = this.users.filter(user => user.roomIdx === roomIdx && user.id === id)[0]
        if(typeof user !="undefined"){
            this.users = this.users.filter((item) => {
                if(item.roomIdx === roomIdx && item.id === id){
                    if(state == "fixMemberOn"){
                        let utype = 4; // 멤버만
                        if(item.userType !=1 && item.userType == 2)
                            utype = 3; // // 멤버,고정
                        item.userType  = utype;
                    }
                    else{
                        let utype = 5;
                        if(item.userType !=1 && item.userType == 3)
                            utype = 2; // 멤버
                        item.userType = utype;
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
