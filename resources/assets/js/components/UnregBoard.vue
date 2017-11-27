<template>
    <div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"  v-for="unregboard in unregboards" :key="unregboard.boardId"> 
                {{ unregboard.boardName }}  
            </li>
        </ul>
    </div>
</template>

<script>
export default {

    data(){
        return{
            unregboards:[]
        }
    } , created: function(){
        this.fetchUnreg()
    }, methods:{
        fetchUnreg: function () {
            console.log("test");
            this.$http.get('/registerlist', function(resp){
                this.unregboards = resp.unRegBoards;
                console.log(resp.unRegBoards);
            }).bind(this);
        }
    } 

}
</script>

<style>

</style>
