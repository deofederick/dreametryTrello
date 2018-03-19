@extends('layouts.app')

@section('content')
<style type="text/css">
.prev {
    float: left;
    padding-top: 10px;
}

.next {
    float: right;
    padding-top: 10px;
}
</style>
<div class="container" id="paddingtop">
    <div class="row">
        <div class="col-md-6">
            <div class="card" id="overflows">
              
              <div id="app">
              <div class="card-body bg-info text-white text-center">
              	<button type="button" class="btn btn-secondary btn-sm prev" v-on:click="prevmonth"><</button>

              	<button type="button" class="btn btn-secondary btn-sm next" v-on:click="nextmonth">></button>
                    <h3 class="panel-hero-title justify-content-center">@{{month}}</h3>
                  </div>
					<ul class="list-group list-group-flush" >
                      <li class="list-group-item" v-cloak v-for="event in events" id="regli">

                          <div class="card-block">
                              
                              <div class="card-title v-cloak--hidden">
                                
                               <!--  <a href="route('registerlist.store')">@{{ unregboard.boardName }}</a> -->
                                <!-- <a href="/registerlist/@{{ regboard.boardId }}"></a> -->
                                 <a class="h5" :href="event.url">
                                @{{ event.title }}</a>
                                <p class="card-text"><small class="text-muted">@{{ event.date }}</small></p>
                              </div>
                              
                          </div>
                      </li>
                  </ul>

                                 
              </div>
            </div>
        </div>

        
    </div>

        <script src="js/app.js"></script>
        <script>
         new Vue({
            el: '#app',
            name: 'test',
            
            data(){
                return{
                      message:'',
                      unregboards:[],
                      months:[],
                      month:'',
                      index:0, 
                      events:[]
                      }
                
              },

              mounted: function(){
              	this.monthnow();
              	this.getevent();
              }, methods:{
              	  monthnow: function(){
              	  	var vm = this;
              	  	vm.$http.get('{{ route('gcal') }}').then(function(response){
                      var dates = response.data.months;
                      vm.months = $.map(dates, function(value, index) {
   						 return [value];
						});
                    }).catch(function(error){

                    });
                    vm.index = vm.months.length-1;
              	  	vm.month = vm.months[vm.index];
              	  },
                  nextmonth: function(){           
                  	var vm = this;
                  	
                  	if(vm.index == vm.months.length-1){
                  		vm.index = vm.months.length-1;
                  	}
                  	else{
                  		vm.index++;	
                  	}
                  	vm.month = vm.months[vm.index];
                  	vm.getevent(vm.month);
                  	console.log(vm.index)
                  },
				prevmonth: function(){           
                  	var vm = this;
                  	
                  	if(vm.index == 0){
                  		vm.index = 0;
                  	}
                  	else{
                  		vm.index--;	
                  	}
                  	vm.month = vm.months[vm.index];
                  	vm.getevent(vm.month);
                  },

                 getevent:function(month){
                 	var vm = this;
                 	
					  console.log(vm.weekCount(2018, 2, 4));
                 	var events = [];
                 	vm.$http.get('{{ route('gcal') }}').then(function(response){
                      var dates = response.data.events;
                      for(var propName in dates) {
                      	 var propValue = dates[propName];
                      	 for(var key in propValue){
                      	 	if(propName == month){
                      	 		events.push({'title':propValue[key]['title'], "date":propValue[key]['date'], "url":propValue[key]['url']})
                      	 	}
                      	 }
					  }
					  vm.events = events;
					  console.log(events);
                    
                    }).catch(function(error){

                    });
                 },

                 weekCount:function(year, month_number, startDayOfWeek) {
					  // month_number is in the range 1..12

					  // Get the first day of week week day (0: Sunday, 1: Monday, ...)
					  var firstDayOfWeek = startDayOfWeek || 0;

					  var firstOfMonth = new Date(year, month_number-1, 1);
					  var lastOfMonth = new Date(year, month_number, 0);
					  var numberOfDaysInMonth = lastOfMonth.getDate();
					  var firstWeekDay = (firstOfMonth.getDay() - firstDayOfWeek + 7) % 7;

					  var used = firstWeekDay + numberOfDaysInMonth;

					  return Math.ceil( used / 7);
					}

              } 

          });


         
        </script>

        
        

@endsection
