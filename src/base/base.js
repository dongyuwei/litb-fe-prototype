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
        add: function(task){
            this.taskList.push(task);
        },
        remove: function(task){
            this.taskList.splice($.inArray(task,this.taskList),1);
        },
        run: function(){
            $.each(this.taskList,function(i,task){
                task();
            });
        }
    };
    litb.task = new Task();
})();
