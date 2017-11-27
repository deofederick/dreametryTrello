<template>
    <div>
        <ul class="list-group list-group-flush" v-for="unregboard in unregboards" :key="unregboard.boardId">
            <li class="list-group-item">
                <p class="card-text">{{ unregboard.boardName }}</p>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data(){
        return{
            unregboards:[
                {
                    "boardName":"Dan Manalili - L2",
                    "boardId":"5935fc808823fdbe2875c07a",
                    "organization":"Dreametry Inc."
                },
                {
                    "boardName":"Dillon - L1",
                    "boardId":"59190bf0b27a6f308820ef7d",
                    "organization":"Dreametry Inc."
                },
                {
                    "boardName":"Dreametry - Santosh Varughese",
                    "boardId":"58a5006e9985e088628f308b",
                    "organization":"Dreametry Inc."
                }
            ]
        }
    }/* , created: function(){
        this.fetchUnreg()
    }, methods:{
        fetchUnreg: function () {
            this.$http.get('/registerlist', function(resp){
                this.unregboards = resp.unRegBoards;
            }).bind(this);
        }
    } */
}
</script>

<style>

</style>
