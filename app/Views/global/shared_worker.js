/**
 * Array to store all the connected ports in.
 */
const LOGGER = {
    debug: false,
    log(data, action = 'log') {
        wrapper = {
            Action: action,
            Message: data,
        }
        if (LOGGER.debug === false) return;
        console.log(data);
        connectedPorts.forEach((port) => port.postMessage(wrapper));
    },
};
const connectedPorts = [];

const Socket = {
    conn: null,
    token: null,
    init() {
        Socket.Try2connect();
    },
    Try2connect: () => {
        Socket.conn = new WebSocket(`ws://localhost:8055?token=${Socket.token}`);
        Socket.conn.onopen = Socket.onopen;
        Socket.conn.onclose = Socket.onclose;
        Socket.conn.onerror = Socket.onerror;
        Socket.conn.onmessage = Socket.onmessage;
    },
    onopen: (e) => {
        LOGGER.log("Connection established!");
    },
    send(data) {
        try {
            Socket.conn.send(JSON.stringify(data));
        } catch (err) {
            LOGGER.log(err);
        }
    },
    onclose: (e) => {
        LOGGER.log("Connection closed");
    },
    onerror: (e) => {
        LOGGER.log("Failed to connect with chat server")
    },
    onmessage: (e) => {
        const package = JSON.parse(e.data);
        connectedPorts.forEach((port) => port.postMessage(package));
    },
    onTokenChange() {
        if (Socket.token != self.name) {
            Socket.token = self.name;
            console.log("TOKEN CHANGED");
            return Socket.init();
        }
    }

}
// to start websocket
// Socket.init();

/**
 * When a new thread is connected to the shared worker,
 * start listening for messages from the new thread.
 */
self.onconnect = function (e) {
    Socket.onTokenChange();
    ports = e.ports;
    const port = ports[0];
    console.log("new port connected..", port);
    // Add this new port to the list of connected ports.
    connectedPorts.push(port);
    port.onmessage = (e) => {
        const {
            action,
            value
        } = e.data;
        // Send message to socket.
        if (action === "send") {
            Socket.onTokenChange();
            console.log("Send Data : ", e.data);
            Socket.send(value);
            // Remove port from connected ports list.
        } else if (action === "unload") {
            const index = connectedPorts.indexOf(port);
            connectedPorts.splice(index, 1);
        } else if (action === "kill") {
            self.close();
        }
    }
    /**
     * Receive data from main thread and determine which
     * actions it should take based on the received data.
     */
    // Start the port broadcasting.
    port.start();
};