function currencyReverseFormat(n, decimal = 0,) {
    var justOneDot = n.toString().replace(/[.](?=.*?\.)/g, '');//look-ahead to replace all but last dot
    return Number(parseFloat(Number(justOneDot.replace(/[^0-9.]/g,''))).toFixed(decimal)) //parse as float and round to 2dp 
} //currencyFormat

// Ex
// alert(currencyReverseFormat('LKR 56,782,43.,000', 2))

function currencyFormat(amount, decimalCount = 0, decimal = '.', thousands = ',') {
    
    n = currencyReverseFormat(amount, decimalCount);
    
    try {
        decimalCount = Math.abs(decimalCount);
        decimalCount = isNaN(decimalCount) ? 2 : decimalCount;
    
        const negativeSign = amount < 0 ? "-" : "";
    
        let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
        let j = (i.length > 3) ? i.length % 3 : 0;
    
        return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
    } catch (e) {
        console.log(e)
    }

} //currencyFormat