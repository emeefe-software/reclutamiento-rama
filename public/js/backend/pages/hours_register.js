const app = new Vue({
    el: '#app',
    mounted(){
    },
    data(){
        var startDate = new Date()
        startDate.setDate(startDate.getDate() + 1)

        return {
            date: null,
            end_date: null,
            time: "11:00:00",
            endTime: "11:00:00",
            context: null,
            contextEnd: null,
            timeFormatted: "11:00",
            endTimeFormatted: "11:00",
            startDate: startDate,
        }
    },
    watch:{
        time: function(newTime){
            this.timeFormatted = newTime ? newTime.substring(0, 5) : null
        },
        endTime: function(newTime){
            this.endTimeFormatted = newTime ? newTime.substring(0, 5) : null
        }
    },
    methods:{
        onContext(ctx) {
            this.context = ctx
        },
        onContextEnd(ctx) {
            this.contextEnd = ctx
        }
    }
});