//initial server initialisations
var express = require('express');
var app = express();
var server = require('http').createServer(app);
var io = require('socket.io').listen(server);

users = []; //array to store usernames
connections = []; //array to store sockets

server.listen(process.env.PORT || 3000); //listen on port 3000 by default
//PORT=4444 node index.js results in node using port 4444
console.log('server running..');

app.get('/', function(req, res){
	res.sendFile(__dirname + '/index.html');
	//sends the html file to node
});

//connect
io.sockets.on('connection', function(socket){
	connections.push(socket);
	//adds socket as a new item to the array connections
	console.log('Connected: %s sockets connected', connections.length);
	//on connection display the number of connected sockets

	//disconnect
	socket.on('disconnect', function(data){
		users.splice(users.indexOf(socket.username), 1);
		//removes (splices) socket.username from the array users
		updateUsernames();
		//updates the active users window by calling a function which calls another function (second one from index.html)
		connections.splice(connections.indexOf(socket), 1);
		//removes (splices) the connection of the socket being disconnected from the connections array
		console.log('Disconnected: %s sockets connected', connections.length);
		//displays that a user has disconnected and displays the number of sockets still connected (as in the number of elements in the array connections)
	});

	//send message 
	socket.on('send message', function(data){
		//once send message is called with the value of textArea passed to it
		io.sockets.emit('new message', {msg: data, user: socket.username});
		//call new message passing the data sent and the username of the socket sending the data
	});

	//newuser
	socket.on('new user', function(data, callback){
		//upon user entering a username and submitting, this function is called
		callback(true);
		//sets callback to true such that the emit function in index.html can be performed
		socket.username = data;
		//sets the socket username to be equal to $username.val()
		users.push(socket.username);
		//adds said username to the users array
		updateUsernames();
		//updates usernames on the interface
	});

	function updateUsernames(){
		io.sockets.emit('get users', users);
		//calls get users passing the array users as the data parameter to be used by the function defined in index.html
	}
});