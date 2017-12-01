<template>
        <ul class="list-group list-group-flush">
<<<<<<< HEAD
            <li class="list-group-item" v-for="(unregboard, index) in unregboards">
                <div class="card-block">
                    <div class="card-title">
                   		{{ unregboard.boardName }}
                    </div>
                </div>
=======
            <li class="list-group-item"  v-for="unregboard in unregboards" :key="unregboard.boardId"> 
                {{ unregboard.boardName }}  
>>>>>>> 7e48000521f3a7805eeb92b835f9bbb5d7eaf2f7
            </li>
        </ul>
</template>

<script>
export default {

    data(){
    	return{

            unregboards: []
    	}
        
    }, created: function(){
        this.fetchUnreg()
    }, methods:{
<<<<<<< HEAD
    		fetchUnreg: function(){
    			var vm = this;

    			$.get('/registerlist', function(json){
    				console.log('testgiididididis');
    				console.log(json)
    				vm.unregboards = json['regBoards'];
    				console.log(unregboards);
    				
    			});
    			/*vm.$http.get('/registerlist').then(function(response){
    				console.log('test');
					//console.log(response.data.unRegBoards[0]);
					//console.log(response);
    				vm.unregboards = response.data.unRegBoards;
    				

    			}).catch(function(error){

    			});*/

    			
    		}


=======
        fetchUnreg: function () {
            console.log("test");
            this.$http.get('/registerlist', function(resp){
                this.unregboards = resp.unRegBoards;
                console.log(resp.unRegBoards);
            }).bind(this);
        }
>>>>>>> 7e48000521f3a7805eeb92b835f9bbb5d7eaf2f7
    } 

}


</script>

<style>

</style>
