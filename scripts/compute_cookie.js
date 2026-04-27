const fs = require('fs');
// load aes.js into this context
eval(fs.readFileSync(__dirname + '/../aes.js', 'utf8'));
function toNumbers(d){var e=[];d.replace(/(..)/g,function(d){e.push(parseInt(d,16))});return e}
function toHex(){for(var d=[],d=1==arguments.length&&arguments[0].constructor==Array?arguments[0]:arguments,e="",f=0;f<d.length;f++)e+=(16>d[f]?"0":"")+d[f].toString(16);return e.toLowerCase()}
var a=toNumbers("f655ba9d09a112d4968c63579db590b4");
var b=toNumbers("98344c2eee86c3994890592585b49f80");
var c=toNumbers("c93747a94b54edf5ca4d13e520a65d0a");
var dec = slowAES.decrypt(c,2,a,b);
console.log(toHex(dec));
