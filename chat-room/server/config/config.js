process.env.PORT = process.env.PORT || 3000
const knex = require('knex')({
    client: 'mysql',
    connection: {
        host : '127.0.0.1',
        user : 'root',
        password : '',
        database : 'powerball_community'+new Date().getFullYear()
    },
});

module.exports = {
    knex
}
