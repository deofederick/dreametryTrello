@extends('layouts.app')

@section('content')
@include('inc.sidebar')
<div id="app">
<div class="container" id="paddingtop">
    <div class="row">
        <div class="col-md-6">
            <div class="card" id="overflows">
              <form method="post" id="form" action="{{ route('setboards') }}">
                 {{ csrf_field() }}
              <input type="hidden" name="_token" id="csrf" value="<?php echo csrf_token(); ?>">
              <div class="card-header bg-success text-white">SELECT BOARD</div>
             
            
              
               <ul class="list-group list-group-flush" id="unreg">
                  <div class="text-center" id="unregload">Loading...</div> 
                  <li class="list-group-item" v-cloak v-for="unregboard in unregboards" id="unregli">
                      <div class="card-block"> 
                                 
                          <div class="card-title v-cloak--hidden">                            
                           <!--  <a href="route('registerlist.store')">@{{ unregboard.boardName }}</a> -->
                           <!--  <a :href="'/registerlist/' + unregboard.boardId"> -->
                           <a :href="unregboard.boardId">
                            @{{ unregboard.name }}</a>
                            <p class="card-text"><small class="text-muted">@{{ unregboard.displayname }}</small></p>
                          
                          </div>
                      </div>
                  </li>
              </ul>
              
               <!--  <test></test> -->
                                 
             </div>
            </div>
       <p id="test"></p>
        <p id="test2"></p>
        <div class="col-md-6">
            <div class="card" id="overflows">
              <div class="card-header bg-warning text-white">REGISTERED BOARDS</div>

               <div class="text-center" id="regload">Loading...</div>
                 <ul class="list-group list-group-flush" >
                      <li class="list-group-item" v-cloak v-for="regboard in regboards" id="regli">

                          <div class="card-block">
                              
                              <div class="card-title v-cloak--hidden">
                                
                               <!--  <a href="route('registerlist.store')">@{{ unregboard.boardName }}</a> -->
                                <!-- <a href="/registerlist/@{{ regboard.boardId }}"></a> -->
                                 <a :href="regboard.boardId">
                                @{{ regboard.name }}</a>
                                <p class="card-text"><small class="text-muted">@{{ regboard.displayname }}</small></p>
                              </div>
                              
                          </div>
                      </li>
                  </ul>
               
            </div>
        </div>
     </div>
       <input type="hidden" id="boardname" name="boards" value="">
     </form>
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
                      regboards:[],
                      csrf: ''
                      }
                
              },

              mounted: function(){
                  this.fetchUnreg()
              }, methods:{
                  fetchUnreg: function(){
                    var vm = this;
                       var alldata = new Array();
                       var b = {};
                       var d;
                        
                  var authenticationSuccess = function() { console.log('Successful authentication'); };
                  var authenticationFailure = function() { console.log('Failed authentication'); };

                  Trello.authorize({
                      type: 'redirect',
                      name: 'Dreametry App',
                      scope: {
                      read: 'true',
                      write: 'true' },
                      expiration: 'never',
                      success: authenticationSuccess,
                      error: authenticationFailure
                  });

                  var retrieveSuccess1 = function(data) {
                    var orgname = data[0]["name"];
                    var displayname = data[0]["displayName"];
                    console.log(displayname);
                    var retrieveSuccess2 = function(data) {
          
                    var g_board=data;
                    
                    //console.log('Boards Data returned:' + JSON.stringify(data));

                    g_board.forEach(function(bx,bi){
                   //console.log(bx.name);

                  //  $('body').append("<h3><a href='"+bx.url+"' target='_blank'>"+bx.name+"</a></h3>");

                  var list = bx.lists;
                  b = bx.lists;
                     
                  var bgImage = bx.prefs.backgroundImage; 

                  if (bgImage != null) {

                     vm.regboards.push({"name": bx.name, "displayname": displayname})
                      alldata.push("1");
                      
                    for (var i = 0; i < list.length; i++) {
                        
                        
                      }
                      
                    }
                    else{
                      vm.unregboards.push({"name": bx.name, "displayname": displayname});
                     
                    }
                  
                    
                })

                }
    
                
          Trello.get("organizations/"+orgname+"/boards?filter=open", {lists: "open", fields: "name,displayName,url,prefs"}, retrieveSuccess2);

                  }

                  Trello.get("members/me/organizations", {fields: "name,displayName,url,closed"}, retrieveSuccess1);
                    var csrf_token = $('meta[name="csrf-token"]').attr('content');
                    b =[1,2,3]
                   document.getElementById('boardname').value = alldata;
                   document.getElementById('test2').value = "alldata";
                   console.log(JSON.stringify(alldata))
                   var c = alldata;
                    var x = {
                      'alldata' : alldata,
                      'd' : d
                    }
                   

                    $.ajax({
                    url         :   "{{ route('setboards') }}",
                    type        :   'post',
                     processData: true,
                      async: true,
                    data        :   {
                        
                        "_token":   csrf_token,
                        "sample":   b,
                        "data"  :   c,
                        "data2" : $("#boardname").val()
                    },
                    success: function(response){
                         //var result = $.parseJSON(response)
                         console.log(response)
                     }, 
                     error: function(response){
                        //var result = $.parseJSON(response)
                         console.log($.parseJSON(response.data))
                     }
                });
                    console.log(x);
                    console.log(alldata);
                    console.log(c);
                  }
                


               }

          });

      
        </script>



        
        <script type="text/javascript">
          var time = setInterval(function(){
            if($('#unregli').length){
              $('#unregload').hide();
              clearInterval(time);
            }
          }, 500)

          var time2 = setInterval(function(){
            if($('#regli').length){
              $('#regload').hide();
              clearInterval(time2);
            }
          }, 500)
  
        </script>


@endsection
