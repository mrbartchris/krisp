var express = require ("express");
var app = express();
var serv = require ("http").Server(app);

app.get('/', function(req, res){
	res.sendFile(__dirname + "/client/index.html");
});
app.use("/client", express.static(__dirname + "/client"));

serv.listen(2000);
console.log("Server Started!");

//list of sockets
var SOCKET_LIST = {};
//list of players
var PLAYER_LIST = {};

function player (id, colour){
  this.id = id;
  this.colour = colour;
  this.board  = new Array(64);
};

var io = require("socket.io")(serv, {});

//var indexes = [];

/*function idCreate(){
  var index = 0;
  var available;
	for(var i = 0; i<4;i++){
    if(indexes[i] === index){
      index++;
    }else{
      index[i] = index;
      available = index;
      break;
    };
  };
//  indexes.sort();
  return available;
};
*/
var colourdecide = function(id){
  if ((id%2) === 0){
    return 'R';
  }else{
    return 'Y';
  };
};

io.sockets.on('connection', function(socket){
  socket.id = Math.floor(Math.random()*5000);
	//socket.id = idCreate();
  console.log(socket.id);
	socket.emit('clientId',socket.id);
  SOCKET_LIST[socket.id] = socket;

  var colour = colourdecide(socket.id);
  var myPlayer = new player(socket.id,colour);
	PLAYER_LIST[socket.id] = myPlayer;

  socket.on('disconnect',function(){
    delete 	SOCKET_LIST[socket.id] ;
    delete PLAYER_LIST[socket.id];
  });

  socket.on('current_index',function(data){
    console.log(data);
    for(var i in PLAYER_LIST){
      var player = PLAYER_LIST[i];
      player.board [data] = player.colour;
            console.log(player.board [data]);
    };
    for(var i in SOCKET_LIST){
      var socket = SOCKET_LIST[i];
      socket.emit('newPosition', data);
      socket.emit('colour',player.board[data]);
    };
  });
});
