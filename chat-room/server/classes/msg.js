
class Msg {
    constructor(){
        this.msgs = []
    }

    createMsg(id,item,level,mark,msg,nickname,sex,winFixCnt,clientId = "",roomIdx="",userType){
        this.msgs.push({id,item,level,mark,msg,nickname,sex,winFixCnt,clientId,roomIdx,userType})
        return this.msgs
    }
    getMsg(id){
        return this.msgs.filter(user => user.id === id)[0]
    }
    getMsgLengthFromRoomIdx(roomIdx){
        return this.msgs.filter(user => user.roomIdx === roomIdx).length
    }

    getFirstMsgByRoomIdx(roomIdx){
        return this.msgs.filter(user => user.roomIdx === roomIdx)[0]
    }

    getMsgRoomIdx(roomIdx){
        if(roomIdx.trim() !="")
          return  this.msgs.filter(x => x.roomIdx == roomIdx);
        else {
          return this.msgs
        }
    }
    deleteFirstMsgByIndex(index){
        this.msgs = this.msgs.splice(index, 1);
    }

    getMsgByClientId(clientId){
        return this.msgs.filter(msg => msg.clientId === clientId)[0]
    }

    getMsg(){
        return this.msgs
    }

    deleteMsgByUserToken(token){
        this.msgs = this.msgs.filter((msg) => msg.id != token)
    }

    deleteMsgByRoomIdx(roomIdx){
        this.msgs = this.msgs.filter((msg) => msg.roomIdx != roomIdx)
    }
}

module.exports = {
    Msg
}
