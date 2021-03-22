
class User {
    constructor(){
        this.users = []
    }

    addUser(id, name,level,nickname,sex,winFixCnt,clientId = "",roomIdx=""){
        this.users.push({id, name,level,nickname,sex,winFixCnt,clientId,roomIdx})
        return this.users
    }
    getUser(id){
        return this.users.filter(user => user.id === id)[0]
    }
    getUserFromIdAndRoomIdx(id,roomIdx){
        return this.users.filter(user => user.id === id && user.roomIdx === roomIdx)[0]
    }
    getUserByClientId(clientId){
        return this.users.filter(user => user.clientId === clientId)[0]
    }
    getUserByName(name){
        return this.users.filter(user => user.name == name)[0]
    }
    getUsers(){
        return this.users
    }
    getUsersFromChatRoom(chatRoom){

    }
    deleteUser(id){
        let deletedUser = this.getUser(id)
        this.users = this.users.filter((user) => user.id != id)
        return deletedUser
    }

    deleteUserByClientId(clientId){
        this.users = this.users.filter((user) => user.clientId != clientId)
    }
}

module.exports = {
    User
}
