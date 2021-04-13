let express = require('express')
let app = express()
const Bitcoin = require('bitcoin-address-generator');
let path = require('path');
let cp = require('cookie-parser');
let b64 = require('base-64')
var bodyParser = require('body-parser')
const port = 3000
app.use(cp());
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'ejs');
app.use(bodyParser.urlencoded({ extended: true }))
app.use(express.static(__dirname + '/demo'));

Object.entries = function( obj ){
    var ownProps = Object.keys( obj ),
       i = ownProps.length,
       resArray = new Array(i);
  
    while (i--)
       resArray[i] = [ownProps[i], obj[ownProps[i]]];
    return resArray;
}

function isInt(value) {
    return !isNaN(value) && (function(x) { return (x | 0) === x; })(parseFloat(value))
  }

app.get("/",(req,res) => {
    res.sendFile(path.join(__dirname+'/templates/index.html'));
})

app.get("/basket",(req,res) => {
    if(req.cookies["basket"]){
        try{
            let content = JSON.parse(b64.decode(req.cookies["basket"]))
            purchases = []
            for(const [key,value] of Object.entries(content["purchases"])){
                purchases.push(value)
            }
            prices = ""
            for(var i=0; i<purchases.length;i++){
                for(const [key,value] of Object.entries(purchases[i])){
                    if(key == "price"){
                        prices += value+"+"
                    }
                }
            }
            prices = prices.substring(0, prices.length-1);
            total = eval(prices)
            numberTotal = purchases.length
            Bitcoin.createWalletAddress(response => {
                bitcoin = response["address"]
            })
            res.render("basket",{
                total: total,
                numberOfItem: numberTotal,
                addrBitcoin: bitcoin
            });
        }catch(error){
            console.log(error)
            var error = "Unrecognize cookie format."
            res.render("403",{
                error: error
            })
        }
    }else{
        var error = "You didn't buy anything."
        res.render("403",{
            error: error
        })
    }
})

app.get("/demonstration",(req,res) => {
    res.sendFile(path.join(__dirname+'/templates/demonstration.html'));
})

app.get("/services/ddos",(req,res) => {
    res.sendFile(path.join(__dirname+'/templates/ddos.html'));
})

app.post("/buy",(req,res) => {
    if(req.body.id != undefined && req.body.type != undefined && req.body.type != undefined){
        if(isInt(req.body.id)){
            if(req.body.type == "malware" || req.body.type == "swat" || req.body.type == "ddos"){
                if(req.cookies['basket']){
                    try{
                        let currentValue = b64.decode(req.cookies['basket']);
                        let jsonVal = JSON.parse(currentValue);
                        var lastKey = 0;
                        for(const [key,value] of Object.entries(jsonVal["purchases"])){
                            lastKey = key;
                        }
                        if(isInt(lastKey)){
                            newKey = parseInt(lastKey) + 1;
                            jsonVal["purchases"][newKey.toString()] = {"type":req.body.type,"id":parseInt(req.body.id),"price":req.body.price}
                            res.cookie('basket',b64.encode(JSON.stringify(jsonVal)),{ maxAge: 900000, httpOnly: true });
                            res.send('{"ok":"Success."}')
                        }else{
                            res.send('{"error":"Stop trying to hack me."}')
                        }
                    }catch(error){
                        res.send('{"error":"Stop trying to hack me."}');
                    }
                }else{
                    let toSend = '{"purchases":{"0":{"type":"'+req.body.type+'","id":'+req.body.id+',"price":"'+req.body.price+'"}}}'
                    res.cookie('basket',b64.encode(toSend),{ maxAge: 900000, httpOnly: true });
                    res.send('{"ok":"Success."}')
                }
            }else{
                res.send('{"error":"Type is invalid."}')
            }
        }else{
            res.send('{"error":"Id is not an integer."}')
        }
    }else{
        res.send('{"error":"Missing fields."}');
    }
})

app.get("/services/malware",(req,res) => {
    res.sendFile(path.join(__dirname+'/templates/malware.html'));
})

app.get("/services/swat",(req,res) => {
    res.sendFile(path.join(__dirname+'/templates/swat.html'));
})

app.listen(port, () => {
    console.log(`App listening at http://localhost:${port}`)
  })