let localAudio = document.getElementById("local-video");
let remoteAudio = document.getElementById("remote-video");
let textElement = document.getElementById("text-element");
let callElement = document.getElementById("call-element");
let secondContent = document.getElementById("second_content");
let calling_div = document.getElementById("calling_div");
const targetDiv = document.querySelector('.appendhere'); 
const sessionid = document.querySelector('#userId'); 
const userId = sessionid.value;  
localAudio.style.opacity = 0;
remoteAudio.style.opacity = 0;
const ip = "192.168.29.100";

let peer;
function onCall(otherUserId) { 
    textElement.value = otherUserId;
    var otherUserId = textElement.value;
    startCall(otherUserId);
}
function checkAvailable(){
    const existConn = peer.connect("reception"); 
    // Handle when the connection is successfully established
    existConn.on('open', () => {
        console.log('Reception is online'); 
        $('.reception_btn').attr('disabled', false);   
    }); 
    existConn.on('error', (err) => {
        console.error('Error in connection:', err); 
        // Handle error as needed
    }); 
    const existConn3 = peer.connect("store");
    existConn3.on('open', () => {
        console.log('Store peer is open'); 
        $('.store_btn').attr('disabled',false);  
    }); 

    const existConn2 = peer.connect("kitchen");
    existConn2.on('open', () => {
        console.log('Kitchen is online'); 
        $('.kitchen_btn').attr('disabled',false);  
    }); 
}

function init() {
    peer = new Peer(userId, {
        host: ip,
        port: 9000,
        path: '/server'
    });

    peer.on('open', function(peerId) {
        console.log(`Peer connected with ID: ${peerId}`); 
        return;
    });
    
    checkAvailable()
   

   
    // peer.on('error', function(err) {
    //     console.log(`Peer ID Exists: ${userId}`);
    //     userId = userId;
    //     calling_div.style.display = "none";
    //     heading2.style.display = "block";
    //     secondContent.style.display = "block";

    //     init();
    // });

    peer.on('connection', (dataConnection) => {
        dataConnection.on('data', (data) => {
            console.log(data)
            if(data.type == "reject"){ 
                localStream.getTracks().forEach(track => track.stop());
            } 
            var html = new DOMParser().parseFromString(data.html, 'text/html').body.firstChild;
            targetDiv.appendChild(html);
        });
    });

    listen();
} 
let localStream;

function listen() {
    peer.on('call', (call) => {
        navigator.getUserMedia({
            audio: true,
            video: false
        }, (stream) => {
            localAudio.srcObject = stream;
            localStream = stream;

            call.answer(stream);
            call.on('stream', (remoteStream) => {
                remoteAudio.srcObject = remoteStream;
            });
        });
    });
}
function startCall(otherUserId) {
    console.log(otherUserId);
    navigator.getUserMedia({
        audio: true,
        video: false
    }, (stream) => {
        localAudio.srcObject = stream;
        localStream = stream;

        const call = peer.call(otherUserId, stream);
        call.on('stream', (remoteStream) => {
            remoteAudio.srcObject = remoteStream;
        });

        const dataConnection = peer.connect(otherUserId);
        dataConnection.on('open', () => {
            const data = {
                type: "incoming",
                html: '<div class="call_log_cont"> <div class="user_phone"> <h4 class="user_name">Room</h4> <span class=phone_no> <i class="fas fa-phone fa-rotate-90"></i> '+userId+' </span> </div> <div class="call_time"> <span class="time"><i class="far fa-clock"></i> 12:00 pm</span> </div> <div class="call_log_cont2  "> <button class="btn btn-success answer-btn" onclick="acceptCall('+userId+')">Answer</button> <button class="end-call-btn btn btn-danger" onclick="rejectCall('+userId+')">Reject</button> </div></div> '
            };
            console.log(data.html)
            // Send the data over the data connection
            dataConnection.send(data);
        });
        
        // Handle received data from the data connection
        dataConnection.on('data', (data) => {
            // Check if the received data is of type "incoming"
            if (data.type === "incoming") {
                // Append the HTML to a container element in the DOM
                const container = document.getElementById('incomingCallsContainer');
                container.innerHTML += data.html;
            }
        });
    });
}

function acceptCall(userId) {  
    var callId = userId;
    // var data = ('<div class="call-box" id="inside_call">Call Rejected</div>');
    var data = {
        type : "answered",
        html : '<div class="call-box2" id="answered_call"><div class="icons"><hr><br><br><i class="fas fa-phone"></i>&nbsp;Call In Process with '+callId+'...<br><br><hr><button class="end-call-btn" onclick="rejectCall('+callId+')">End</button></div></div>'
    }
    const dataConnection = peer.connect(callId);  
    dataConnection.on('open', function(callId) {
        console.log(`Answered: ${userId}`); 
        if (peer.connections[callId]) { 
            const call = peer.connections[callId][0]; 
            if (call) { 
                call.answer(localStream);
            }
        }
        var html = '<div class="call-box2" id="answered_call"><div class="icons"><hr><br><br><i class="fas fa-phone"></i>&nbsp;Call In Process with '+callId+'...<br><br><hr><button class="end-call-btn" onclick="rejectCall('+callId+')">End</button></div></div>'; 
        targetDiv.innerHTML = html; 
        dataConnection.send(data)
        return;
    });  
}

function rejectCall(userId) { 
    var callId = userId;
    // var data = ('<div class="call-box" id="inside_call">Call Rejected</div>');
    var data = {
        type : "reject",
        html : '<div class="call-box" id="inside_call">Call Rejected</div>'
    }
    const dataConnection = peer.connect(callId); 
    dataConnection.on('open', function(callId) {
        console.log(`Rejected: ${userId}`);
        if (peer.connections[callId]) { 
            const call = peer.connections[callId][0]; 
            if (call) { 
                call.close();
                if (localStream) {
                    localStream.getTracks().forEach(track => track.stop());
                }
            }
        } 
        var html = ""; 
        targetDiv.innerHTML = html; 
        dataConnection.send(data)
        return;
    });  
}


function notifySenderCallRejected(callId) {
    // Assuming userId 1 is the sender
    const senderId = 1;
    const dataConnection = peer.connect(senderId); // Connect to user 1
    dataConnection.on('open', () => {
        // Send a message to user 1 indicating that the call has been rejected
        dataConnection.send(`Call ${callId} has been rejected`);
    });
} 

function toggleAudio(b) {
    if (b == "true") {
        localStream.getAudioTracks()[0].enabled = true;
    } else {
        localStream.getAudioTracks()[0].enabled = false;
    }
}

// Call init function to start
init();
