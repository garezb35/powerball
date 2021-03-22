
class Msg {
    constructor(){
        this.msgs = []
    }

    createMsg(id, name,item,level,mark,msg,nickname,sex,winFixCnt,clientId = "",roomIdx=""){
        this.msgs.push({id, name,item,level,mark,msg,nickname,sex,winFixCnt,clientId,roomIdx})
        return this.msgs
    }
    getMsg(id){
        return this.msgs.filter(user => user.id === id)[0]
    }
    getMsgFromRoomIdx(roomIdx){
        return this.msgs.filter(user => user.roomIdx === roomIdx)[0]
    }
    getMsgByClientId(clientId){
        return this.msgs.filter(user => user.clientId === clientId)[0]
    }
    getMsg(){
        return this.msgs
    }

    deleteMsgByUserToken(id){
        let deletedUser = this.getUser(id)
        this.msgs = this.msgs.filter((user) => user.id != id)
        return deletedUser
    }

    deleteMsgByRoomIdx(roomIdx){
        this.msgs = this.msgs.filter((user) => user.roomIdx != roomIdx)
    }
}

module.exports = {
    Msg
}
