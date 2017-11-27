<template>
    <div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"  v-for="unregboard in unregboards" :key="unregboard.boardId">
                <div class="card-block">
                    <div class="card-title">
                        @{{ unregboard.boardName }}
                    </div>
                </div>
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
    }    , created: function(){
        this.fetchUnreg()
    }, methods:{
        fetchUnreg: function () {


                this.$http.get('/registerlist', function(resp){
                this.unregboards = resp.unRegBoards;

            }).bind(this);
        }
    } 
}
</script>

<style>

</style>
