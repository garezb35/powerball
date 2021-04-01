
class User {
    constructor(){
        this.users = []
    }

    addUser(id, name,level,nickname,sex,winFixCnt,clientId = "",roomIdx="",time=0,mark="",item="",lobby="",image="",today="",userType=0){
        this.users.push({id, name,level,nickname,sex,winFixCnt,clientId,roomIdx,time,mark,item,lobby,image,today,userType})
        return this.users
    }
    getUser(id){
        return this.users.filter(user => user.id === id)[0]
    }
    getUserFromIdAndRoomIdx(id,lobby){
        return this.users.filter(user => user.id === id && user.lobby === lobby)[0]
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
}

module.exports = {
    User
}
