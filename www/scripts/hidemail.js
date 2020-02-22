/* Following lines used to dynamically include dependent javascript files. Do not alter
php-include http://cachefile.net/scripts/jquery/1.2.1/jquery-1.2.1.pack.js
*/

jQuery(function($){
hidemail = {
    node : 'address',
    at : '[at]',
    dot : '[dot]',
    classname : 'email',
    activate : function(){
        $(hidemail.node + "." + hidemail.classname).each(function(i){
            if ($(this).text()){
                var adr = $(this).text().replace(hidemail.at,"@").replace(hidemail.dot,".");
                $(this).empty()
                    .removeClass('email')
                    .append('<a class="email" href="mailto:' + adr + '" rel="contact">' + adr + '</a>');
            }
        });
        return;
    }
};
hidemail.activate();
});