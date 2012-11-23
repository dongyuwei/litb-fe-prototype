if(typeof require === 'undefined'){
    function require(src){
        var script = document.createElement('script');
        script.src = src;
        document.body && document.body.appendChild(script);
    }
}



var litb = window.litb || {};
(function(){
    var Task = function(){
        this.taskList = [];
    };
    Task.prototype = {
        add: function(job){
            this.taskList.push(job);
        },
        delete: function(){
            
        },
        run: function(){
            
        }
    };
})();
