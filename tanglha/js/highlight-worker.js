onmessage = function(event) {
    importScripts('highlight.min.js');
    var result = event.data.lang.length==0 ? self.hljs.highlightAuto(event.data.content) : self.hljs.highlightAuto(event.data.content, event.data.lang);
    console.log(result);
    postMessage(result.value);
}
