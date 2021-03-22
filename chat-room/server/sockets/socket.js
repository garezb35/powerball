const {io} = require('../server')
const {
    createMessage,
    checkInPacket,
    deleteUserById,
    deleteUserByClientId
} = require('../utils/utils')

io.set('origins', ['cake6978.com:*']);

let public_msg = new Array();
let private_msg = new Array();

let public = io.of("/public");
public.on("connection",(client) => {
    client.on('disconnect', () => {
        deleteUserByClientId(client.id);
    })
    client.on("send",(data,callback) => {
        checkInPacket(data,client);
    })
});

module.exports = {
    public_msg,
    private_msg
}

