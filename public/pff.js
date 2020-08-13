let ws = new WebSocket("ws://localhost:9502/");
ws.onopen = ev => console.log(ev);
ws.onclose = ev => console.log(ev);
ws.onerror = ev => console.log(ev);
ws.onmessage = ev => {
	const r = JSON.parse(ev.data);
	if (r.hasOwnProperty("alert"))
		alert(r.alert);
};

let observer = new MutationObserver(function (mutations) {
	mutations.forEach(mut => {
		mut.addedNodes.forEach(node => {
			if (typeof node.onclick == "function")
				node.onclick = () => ws.send(JSON.stringify({id: node.getAttribute("id"), action: 'click'}));
		})
	})
});

observer.observe(document, {
	childList: true,
	subtree: true,
	attributes: true
});
