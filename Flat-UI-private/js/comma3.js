/* 3桁カンマプラグイン for jQuery 
2009.1 By KaZuhiro FuRuhata  */  
$.fn.comma3 = function(){  
    return this.each(function(){  
        var num3string = (function(num){  
                var str = new String(num);  
                var n = "";  
                var count = 0;  
                for (var i=str.length-1; i>=0; i--){  
                    n = str.charAt(i) + n;  
                    count++;  
                    if (((count % 3) == 0) && (i != 0)) n = ","+n;  
                }  
                return n;  
            })(this.innerHTML);  
        this.innerHTML = num3string;  
    });  
}  