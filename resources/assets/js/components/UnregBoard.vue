<template>
        <ul class="list-group list-group-flush">
            <li class="list-group-item" v-for="(unregboard, index) in unregboards">
                <div class="card-block">
                    <div class="card-title">
                   		{{ unregboard.boardName }}
                    </div>
                </div>
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


    } 
}


</script>

<style>

</style>
