@extends('layouts.app')

@section('content')
@include('inc.loading')


<div class="vueapp container" id="paddingtop">
  <div class="row justify-content-center" v-for="allcount in allcounts">
    <div class="col-md-2 placeholder justify-content-center text-center" id="tasktoday">
      <img src="data:image/gif;base64,R0lGODlhAQABAIABAADcgwAAACwAAAAAAQABAAACAkQBADs=" width="80" height="80" class="img-fluid rounded-circle" alt="Generic placeholder thumbnail">
      <div class="centered text-white"><h1 style="font-size: 147%;">@{{ allcount.daily_count }}</h1></div>
      <h4>Today</h4>
      <div class="text-muted"><span>@{{new Date() | moment("dddd, MMM D") }}</span></div>
    </div>
  
    <div class="col-md-2 placeholder justify-content-center text-center" id="tasktoday">
      <img src="data:image/gif;base64,R0lGODlhAQABAPAAAPqmMgAAACH5BAAAAAAAIf8LTUdLOEJJTTAwMDD/OEJJTQQlAAAAAAAQAAAAAAAAAAAAAAAAAAAAADhCSU0EOgAAAAAA5QAAABAAAAABAAAAAAALcHJpbnRPdXRwdXQAAAAFAAAAAFBzdFNib29sAQAAAABJbnRlZW51bQAAAABJbnRlAAAAAENscm0AAAAPcHJpbnRTaXh0ZWVuQml0Ym9vbAAAAAALcHJpbnRlck5hbWVURVhUAAAAAQAAAAAAD3ByaW50UHJvb2ZTZXR1cE9iamMAAAAMAFAAcgBvAG8AZgAgAFMAZQB0AHUAcAAAAAAACnByb29mU2V0dXAAAAABAAAAAEJsdG5lbnVtAAAADGJ1aWx0aW5Qcm9v/2YAAAAJcHJvb2ZDTVlLADhCSU0EOwAAAAACLQAAABAAAAABAAAAAAAScHJpbnRPdXRwdXRPcHRpb25zAAAAFwAAAABDcHRuYm9vbAAAAAAAQ2xicmJvb2wAAAAAAFJnc01ib29sAAAAAABDcm5DYm9vbAAAAAAAQ250Q2Jvb2wAAAAAAExibHNib29sAAAAAABOZ3R2Ym9vbAAAAAAARW1sRGJvb2wAAAAAAEludHJib29sAAAAAABCY2tnT2JqYwAAAAEAAAAAAABSR0JDAAAAAwAAAABSZCAgZG91YkBv4AAAAAAAAAAAAEdybiBkb3ViQG/gAAAAAAAAAAAAQv9sICBkb3ViQG/gAAAAAAAAAAAAQnJkVFVudEYjUmx0AAAAAAAAAAAAAAAAQmxkIFVudEYjUmx0AAAAAAAAAAAAAAAAUnNsdFVudEYjUHhsQFIAAAAAAAAAAAAKdmVjdG9yRGF0YWJvb2wBAAAAAFBnUHNlbnVtAAAAAFBnUHMAAAAAUGdQQwAAAABMZWZ0VW50RiNSbHQAAAAAAAAAAAAAAABUb3AgVW50RiNSbHQAAAAAAAAAAAAAAABTY2wgVW50RiNQcmNAWQAAAAAAAAAAABBjcm9wV2hlblByaW50aW5nYm9vbAAAAAAOY3JvcFJlY3RCb3R0b21sb25nAAD/AAAAAAAMY3JvcFJlY3RMZWZ0bG9uZwAAAAAAAAANY3JvcFJlY3RSaWdodGxvbmcAAAAAAAAAC2Nyb3BSZWN0VG9wbG9uZwAAAAAAOEJJTQPtAAAAAAAQAEgAAAABAAEASAAAAAEAAThCSU0EJgAAAAAADgAAAAAAAAAAAAA/gAAAOEJJTQQNAAAAAAAEAAAAWjhCSU0EGQAAAAAABAAAAB44QklNA/MAAAAAAAkAAAAAAAAAAAEAOEJJTScQAAAAAAAKAAEAAAAAAAAAAThCSU0D9QAAAAAASAAvZmYAAQBsZmYABgAAAAAAAQAvZmYAAQChmZoABgAAAAAAAQAy/wAAAAEAWgAAAAYAAAAAAAEANQAAAAEALQAAAAYAAAAAAAE4QklNA/gAAAAAAHAAAP////////////////////////////8D6AAAAAD/////////////////////////////A+gAAAAA/////////////////////////////wPoAAAAAP////////////////////////////8D6AAAOEJJTQQAAAAAAAACAAA4QklNBAIAAAAAAAIAADhCSU0EMAAAAAAAAQEAOEJJTQQtAAAAAAAGAAEAAAACOEJJTQQIAAAAAAAQAAAAAQAAAkAAAAJAAAAAADhCSU0EHgAAAP8AAAQAAAAAOEJJTQQaAAAAAANJAAAABgAAAAAAAAAAAAAAAQAAAAEAAAAKAFUAbgB0AGkAdABsAGUAZAAtADEAAAABAAAAAAAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAEAAAABAAAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAAAAAAAEAAAAAEAAAAAAABudWxsAAAAAgAAAAZib3VuZHNPYmpjAAAAAQAAAAAAAFJjdDEAAAAEAAAAAFRvcCBsb25nAAAAAAAAAABMZWZ0bG9uZwAAAAAAAAAAQnRvbWxvbmcAAAABAAAAAFJnaHRsb25nAAAAAQD/AAAGc2xpY2VzVmxMcwAAAAFPYmpjAAAAAQAAAAAABXNsaWNlAAAAEgAAAAdzbGljZUlEbG9uZwAAAAAAAAAHZ3JvdXBJRGxvbmcAAAAAAAAABm9yaWdpbmVudW0AAAAMRVNsaWNlT3JpZ2luAAAADWF1dG9HZW5lcmF0ZWQAAAAAVHlwZWVudW0AAAAKRVNsaWNlVHlwZQAAAABJbWcgAAAABmJvdW5kc09iamMAAAABAAAAAAAAUmN0MQAAAAQAAAAAVG9wIGxvbmcAAAAAAAAAAExlZnRsb25nAAAAAAAAAABCdG9tbG9uZwAAAAEAAAAAUmdodGxvbmcAAAAB/wAAAAN1cmxURVhUAAAAAQAAAAAAAG51bGxURVhUAAAAAQAAAAAAAE1zZ2VURVhUAAAAAQAAAAAABmFsdFRhZ1RFWFQAAAABAAAAAAAOY2VsbFRleHRJc0hUTUxib29sAQAAAAhjZWxsVGV4dFRFWFQAAAABAAAAAAAJaG9yekFsaWduZW51bQAAAA9FU2xpY2VIb3J6QWxpZ24AAAAHZGVmYXVsdAAAAAl2ZXJ0QWxpZ25lbnVtAAAAD0VTbGljZVZlcnRBbGlnbgAAAAdkZWZhdWx0AAAAC2JnQ29sb3JUeXBlZW51bQAAABFFU2xpY2VCR0NvbG9yVHlwZQAAAP8ATm9uZQAAAAl0b3BPdXRzZXRsb25nAAAAAAAAAApsZWZ0T3V0c2V0bG9uZwAAAAAAAAAMYm90dG9tT3V0c2V0bG9uZwAAAAAAAAALcmlnaHRPdXRzZXRsb25nAAAAAAA4QklNBCgAAAAAAAwAAAACP/AAAAAAAAA4QklNBBQAAAAAAAQAAAACOEJJTQQMAAAAAAI0AAAAAQAAAAEAAAABAAAABAAAAAQAAAIYABgAAf/Y/+0ADEFkb2JlX0NNAAH/7gAOQWRvYmUAZIAAAAAB/9sAhAAMCAgICQgMCQkMEQsKCxEVDwwMDxUYExMVExMYEQwMDAwMDBEMDAwMDAz/DAwMDAwMDAwMDAwMDAwMDAwMDAwMDAENCwsNDg0QDg4QFA4ODhQUDg4ODhQRDAwMDAwREQwMDAwMDBEMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwM/8AAEQgAAQABAwEiAAIRAQMRAf/dAAQAAf/EAT8AAAEFAQEBAQEBAAAAAAAAAAMAAQIEBQYHCAkKCwEAAQUBAQEBAQEAAAAAAAAAAQACAwQFBgcICQoLEAABBAEDAgQCBQcGCAUDDDMBAAIRAwQhEjEFQVFhEyJxgTIGFJGhsUIjJBVSwWIzNHKC0UMHJZJT8OHxY3M1FqKygyZEk1RkRcKjdDYX0lXi/2Xys4TD03Xj80YnlKSFtJXE1OT0pbXF1eX1VmZ2hpamtsbW5vY3R1dnd4eXp7fH1+f3EQACAgECBAQDBAUGBwcGBTUBAAIRAyExEgRBUWFxIhMFMoGRFKGxQiPBUtHwMyRi4XKCkkNTFWNzNPElBhaisoMHJjXC0kSTVKMXZEVVNnRl4vKzhMPTdePzRpSkhbSVxNTk9KW1xdXl9VZmdoaWprbG1ub2JzdHV2d3h5ent8f/2gAMAwEAAhEDEQA/AOhSXhKS5N33/9k4QklNBCEAAAAAAF0AAAABAQAAAA8AQQBkAG8AYgBlACAAUABoAG8AdABvAHMAaABvAHAAAEkAFwBBAGQAbwBiAGUAIABQAGgAbwB0AG8AcwBoAG8AcAAgAEMAQwAgADIAMAAxADUAAAABADhCSU0EBgAAAAAABwAEAAAAAQEAACH/C0lDQ1JHQkcxMDEy/wAADEhMaW5vAhAAAG1udHJSR0IgWFlaIAfOAAIACQAGADEAAGFjc3BNU0ZUAAAAAElFQyBzUkdCAAAAAAAAAAAAAAABAAD21gABAAAAANMtSFAgIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEWNwcnQAAAFQAAAAM2Rlc2MAAAGEAAAAbHd0cHQAAAHwAAAAFGJrcHQAAAIEAAAAFHJYWVoAAAIYAAAAFGdYWVoAAAIsAAAAFGJYWVoAAAJAAAAAFGRtbmQAAAJUAAAAcGRtZGQAAALEAAAAiHZ1ZWQAAANMAAAAhnZpZf93AAAD1AAAACRsdW1pAAAD+AAAABRtZWFzAAAEDAAAACR0ZWNoAAAEMAAAAAxyVFJDAAAEPAAACAxnVFJDAAAEPAAACAxiVFJDAAAEPAAACAx0ZXh0AAAAAENvcHlyaWdodCAoYykgMTk5OCBIZXdsZXR0LVBhY2thcmQgQ29tcGFueQAAZGVzYwAAAAAAAAASc1JHQiBJRUM2MTk2Ni0yLjEAAAAAAAAAAAAAABJzUkdCIElFQzYxOTY2LTIuMQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAWFlaIAAAAAAAAPNRAAH/AAAAARbMWFlaIAAAAAAAAAAAAAAAAAAAAABYWVogAAAAAAAAb6IAADj1AAADkFhZWiAAAAAAAABimQAAt4UAABjaWFlaIAAAAAAAACSgAAAPhAAAts9kZXNjAAAAAAAAABZJRUMgaHR0cDovL3d3dy5pZWMuY2gAAAAAAAAAAAAAABZJRUMgaHR0cDovL3d3dy5pZWMuY2gAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAZGVzYwAAAAAAAAAuSUVDIDYxOTY2LTIuMSBEZWZhdWx0IFJHQiBjb2xvdXIgc3BhY2UgLSBzUkdC/wAAAAAAAAAAAAAALklFQyA2MTk2Ni0yLjEgRGVmYXVsdCBSR0IgY29sb3VyIHNwYWNlIC0gc1JHQgAAAAAAAAAAAAAAAAAAAAAAAAAAAABkZXNjAAAAAAAAACxSZWZlcmVuY2UgVmlld2luZyBDb25kaXRpb24gaW4gSUVDNjE5NjYtMi4xAAAAAAAAAAAAAAAsUmVmZXJlbmNlIFZpZXdpbmcgQ29uZGl0aW9uIGluIElFQzYxOTY2LTIuMQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAdmlldwAAAAAAE6T+ABRfLgAQzxQAA+3MAAQTCwADXJ4AAAABWFlaIP8AAAAAAEwJVgBQAAAAVx/nbWVhcwAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAAAAAo8AAAACc2lnIAAAAABDUlQgY3VydgAAAAAAAAQAAAAABQAKAA8AFAAZAB4AIwAoAC0AMgA3ADsAQABFAEoATwBUAFkAXgBjAGgAbQByAHcAfACBAIYAiwCQAJUAmgCfAKQAqQCuALIAtwC8AMEAxgDLANAA1QDbAOAA5QDrAPAA9gD7AQEBBwENARMBGQEfASUBKwEyATgBPgFFAUwBUgFZAWABZwFuAXUBfAGDAYsBkgGaAaEBqQGxAbkBwQHJAdEB2QHhAekB8gH6AgMCDAL/FAIdAiYCLwI4AkECSwJUAl0CZwJxAnoChAKOApgCogKsArYCwQLLAtUC4ALrAvUDAAMLAxYDIQMtAzgDQwNPA1oDZgNyA34DigOWA6IDrgO6A8cD0wPgA+wD+QQGBBMEIAQtBDsESARVBGMEcQR+BIwEmgSoBLYExATTBOEE8AT+BQ0FHAUrBToFSQVYBWcFdwWGBZYFpgW1BcUF1QXlBfYGBgYWBicGNwZIBlkGagZ7BowGnQavBsAG0QbjBvUHBwcZBysHPQdPB2EHdAeGB5kHrAe/B9IH5Qf4CAsIHwgyCEYIWghuCIIIlgiqCL4I0gjnCPsJEAklCToJTwlk/wl5CY8JpAm6Cc8J5Qn7ChEKJwo9ClQKagqBCpgKrgrFCtwK8wsLCyILOQtRC2kLgAuYC7ALyAvhC/kMEgwqDEMMXAx1DI4MpwzADNkM8w0NDSYNQA1aDXQNjg2pDcMN3g34DhMOLg5JDmQOfw6bDrYO0g7uDwkPJQ9BD14Peg+WD7MPzw/sEAkQJhBDEGEQfhCbELkQ1xD1ERMRMRFPEW0RjBGqEckR6BIHEiYSRRJkEoQSoxLDEuMTAxMjE0MTYxODE6QTxRPlFAYUJxRJFGoUixStFM4U8BUSFTQVVhV4FZsVvRXgFgMWJhZJFmwWjxayFtYW+hcdF0EXZReJF/+uF9IX9xgbGEAYZRiKGK8Y1Rj6GSAZRRlrGZEZtxndGgQaKhpRGncanhrFGuwbFBs7G2MbihuyG9ocAhwqHFIcexyjHMwc9R0eHUcdcB2ZHcMd7B4WHkAeah6UHr4e6R8THz4faR+UH78f6iAVIEEgbCCYIMQg8CEcIUghdSGhIc4h+yInIlUigiKvIt0jCiM4I2YjlCPCI/AkHyRNJHwkqyTaJQklOCVoJZclxyX3JicmVyaHJrcm6CcYJ0kneierJ9woDSg/KHEooijUKQYpOClrKZ0p0CoCKjUqaCqbKs8rAis2K2krnSvRLAUsOSxuLKIs1y0MLUEtdi2rLeH/LhYuTC6CLrcu7i8kL1ovkS/HL/4wNTBsMKQw2zESMUoxgjG6MfIyKjJjMpsy1DMNM0YzfzO4M/E0KzRlNJ402DUTNU01hzXCNf02NzZyNq426TckN2A3nDfXOBQ4UDiMOMg5BTlCOX85vDn5OjY6dDqyOu87LTtrO6o76DwnPGU8pDzjPSI9YT2hPeA+ID5gPqA+4D8hP2E/oj/iQCNAZECmQOdBKUFqQaxB7kIwQnJCtUL3QzpDfUPARANER0SKRM5FEkVVRZpF3kYiRmdGq0bwRzVHe0fASAVIS0iRSNdJHUljSalJ8Eo3Sn1KxEsMS1NLmkviTCpMcky6TQJN/0pNk03cTiVObk63TwBPSU+TT91QJ1BxULtRBlFQUZtR5lIxUnxSx1MTU19TqlP2VEJUj1TbVShVdVXCVg9WXFapVvdXRFeSV+BYL1h9WMtZGllpWbhaB1pWWqZa9VtFW5Vb5Vw1XIZc1l0nXXhdyV4aXmxevV8PX2Ffs2AFYFdgqmD8YU9homH1YklinGLwY0Njl2PrZEBklGTpZT1lkmXnZj1mkmboZz1nk2fpaD9olmjsaUNpmmnxakhqn2r3a09rp2v/bFdsr20IbWBtuW4SbmtuxG8eb3hv0XArcIZw4HE6cZVx8HJLcqZzAXNdc7h0FHRwdMx1KHWFdeF2Pv92m3b4d1Z3s3gReG54zHkqeYl553pGeqV7BHtje8J8IXyBfOF9QX2hfgF+Yn7CfyN/hH/lgEeAqIEKgWuBzYIwgpKC9INXg7qEHYSAhOOFR4Wrhg6GcobXhzuHn4gEiGmIzokziZmJ/opkisqLMIuWi/yMY4zKjTGNmI3/jmaOzo82j56QBpBukNaRP5GokhGSepLjk02TtpQglIqU9JVflcmWNJaflwqXdZfgmEyYuJkkmZCZ/JpomtWbQpuvnByciZz3nWSd0p5Anq6fHZ+Ln/qgaaDYoUehtqImopajBqN2o+akVqTHpTilqaYapoum/adup+CoUqjEqTepqar/HKqPqwKrdavprFys0K1ErbiuLa6hrxavi7AAsHWw6rFgsdayS7LCszizrrQltJy1E7WKtgG2ebbwt2i34LhZuNG5SrnCuju6tbsuu6e8IbybvRW9j74KvoS+/796v/XAcMDswWfB48JfwtvDWMPUxFHEzsVLxcjGRsbDx0HHv8g9yLzJOsm5yjjKt8s2y7bMNcy1zTXNtc42zrbPN8+40DnQutE80b7SP9LB00TTxtRJ1MvVTtXR1lXW2Ndc1+DYZNjo2WzZ8dp22vvbgNwF3IrdEN2W3hzeot8p36/gNuC94UThzOJT4tvjY+Pr5HPk/OWE5g3mlucf56noMui8VOlG6dDqW+rl63Dr++yG7RHtnO4o7rTvQO/M8Fjw5fFy8f/yjPMZ86f0NPTC9VD13vZt9vv3ivgZ+Kj5OPnH+lf65/t3/Af8mP0p/br+S/7c/23//wAsAAAAAAEAAQAAAgJEAQA7" width="80" height="80" class="img-fluid rounded-circle" alt="Generic placeholder thumbnail">
      <div class="centered text-white"><h1 style="font-size: 147%;">@{{ allcount.weekly_count }}</h1></div>
      <h4>This week</h4>
      <div class="text-muted">@{{ new Date() | moment("Wo") + " week" }}</div>
    </div>

    <div class="col-md-2 placeholder justify-content-center text-center" id="tasktoday">
      <img src="data:image/gif;base64,R0lGODlhAQABAIABAAJ12AAAACwAAAAAAQABAAACAkQBADs=" width="80" height="80" class="img-fluid rounded-circle" alt="Generic placeholder thumbnail">
      <div class="centered text-white"><h1 style="font-size: 147%;">@{{ allcount.monthly_count }}</h1></div>
      <h4>This month</h4>
      <div class="text-muted">@{{ new Date() | moment("MMMM YYYY") }}</div>
    </div>
  </div>
  


    <div class="row">
        <div class="col-md-6">
          <!-- <div class="container-fluid"> -->
            <div class="card" id="counter">
              <div class="card-header bg-success text-white">FINISHED TODAY</div>
                <div class="container row justify-content-center text-center" id="app">
                
                <div class="col-md-3" id="countercards"  v-for="(finished, index) in finishedtoday">

                  <div class="pulse card" v-bind:id="'finish' + (index + 1)">
                    <div class="card-header" id="name"><small>@{{ finished.name }}</small></div>
                    <div class="card-text"><h1>@{{finished.count}}</h1></div>
                  </div>
                </div>
             

              <!-- <div class="col-md-3" id="countercards">
                <div class="card">
                  <div class="card-header">Lorem</div>
                  <div class="card-text"><h1>0</h1></div>
                </div>
              </div> -->

                </div>
              </div>
            <!-- </div> -->
          </div>

        <div class="col-md-6">
            <div class="card" id="counter">
              <div class="card-header bg-danger text-white">TASKS IN PROGRESS</div>
            <div class="container row justify-content-center text-center" id="app2" >
            
            
              <div class="col-md-3 tasksss" id="countercards" v-for="(pending, index) in pendingtasks">
                <div class="pulse card" v-bind:id="'task' + (index + 1)">
                  <div class="card-header"><small>@{{ pending.name }}</small></div>
                  <div class="card-text" contenteditable="false"><h1>@{{ pending.count }}</h1></div>
                </div>
              </div>
          

              <!-- <div class="col-md-3" id="countercards">
                <div class="card">
                  <div class="card-header">Lorem</div>
                  <div class="card-text"><h1>0</h1></div>
                </div>
              </div> -->

            </div>
            </div>
        </div>
  </div>
  <div id="app">
  <table class="table table-striped table-dark" id="livetable">

  <thead>
    <tr>
      <th scope="col">No.</th>
      <th scope="col">Name</th>
      <th scope="col">Today</th>
      <th scope="col">This Week</th>
      <th scope="col">This Month</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(count, index) in tablecounts" :key="index">
      <td>@{{ index + 1 }}</td>
      <td>@{{ count.name }}</td>
      <td>@{{ count.daily_count }}</td>
      <td>@{{ count.weekly_count }}</td>
      <td>@{{ count.monthly_count }}</td>
    </tr>
  </tbody>
</table>

<ol id="demo"></ol>
</div>

</div>
<div class="log"></div>
<script src="js/app.js"></script>
<script>
 new Vue({
    el: '.vueapp',
    name: 'test',
    data(){
        return{
              message:'',
              finishedtoday:[],
              tablecounts:[],
              pendingtasks:[],
              allcounts:[], 
              done:[]
              }
        
      },

      mounted: function(){
         this.fetchlists(),
         this.animate(),
         this.fetchFinished()
          /*this.fetchPending(),
          this.fetchAll()*/
          
      },methods:{
          fetchFinished: function(){
            var vm = this;
            var finishedtodays = [];
            var pendingsss = [];

             vm.$http.get('/getcards').then(function(response){
       
          
              var name = response.body.daily;
               vm.allcounts = response.body.allcount;
               var name2 = response.body.allpending;
               vm.tablecounts = name;
         
              //for finsihed today
              name.forEach(function(key, value){
                var count = key.daily_count;
                var name = key.name

                finishedtodays.push({"name": name.split(" ")[0], "count": count});

              });
              console.log('test');
               /*name2.forEach(function(key, value){
                var firstname = key.name
                var count = key.count

                pendingsss.push({"name": firstname.split(" ")[0], "count": count});

               });

             
              vm.pendingtasks = pendingsss;*/
               vm.finishedtoday = finishedtodays;

              //for pending tasks
              console.log('test1');
              console.log(response.body.allcount);  
              setTimeout(this.fetchFinished.bind(this), 3000);          

            }).catch(function(error){
            });

           
             
            
          },

       animate: function(){

             $("div").on('DOMSubtreeModified', ".card-text", function()
                      {

                          var id =  $(this).parents(".pulse").attr('id');
                          console.log(id);
                          $('#'+id).addClass('pulse-active')
                          setTimeout(function(){ $('#'+id).removeClass('pulse-active') }, 1000)
                         // self.isActive = true;

                         // setTimeout(function(){ self.isActive = false; }, 1000);
                           $('#'+id).addClass('pulse-active')
                          setTimeout(function(){ $('#'+id).removeClass('pulse-active') }, 1000)

                      })

              },

    countcomment: function(username){
      var array = [];
      array.push(username);
      console.log(compressArray(array));
     },

     getcards: function(data){
      var vm = this;
      vm.$http.get('/getuser').then(function(response){
           var boards = response.body.boards;
           var users = response.body.users;
           var pendings = [];
      users.forEach(function(user, value){
        data.forEach(function(bx, bi){
          var usercount = 0;
            var actionSuccess = function(actiondata){
               var members = bx.idMembers;
                members.forEach(function(member, value){
                    if(member == user.trelloId){
                       actiondata.forEach(function(action, bi){ 
                        if (action.type == "commentCard" && (action.data.text.includes("Working on") || action.data.text.includes("working on") || action.data.text.includes("WORKING ON"))){
                               pendings.push(user.name)
                                          
                            }
                                  
                        });
                    }
                });

          };

             Trello.get("cards/"+bx.id+"/actions", actionSuccess);

          });
      });
          
          console.log(pendings);


          
          

        }).catch(function(error){
        
                   });
     
     },

     fetchlists: function(){
        var vm = this;
        vm.$http.get('/getuser').then(function(response){
           var boards = response.body.boards;
           var users = response.body.users;
           boards.forEach(function(board, value){

               var retrieveSuccess = function(data) {
               
                g_board=data;
                //console.log('Boards Data returned:' + JSON.stringify(data));
               var todo = [];
                  var forreview = [];
                  var done = [];
                g_board.forEach(function(bx,bi){
                 

                  if(bx.name == "Done"){
                     vm.fetchdone(bx.id);

                  }

                
            })
            
            
          };

            Trello.get("boards/"+board.board_id+"/lists", {fields: "name,displayName,url,prefs"}, retrieveSuccess);

        });

        setTimeout(this.fetchlists.bind(this), 3000);


        }).catch(function(error){
        
                   });
        

      
     },

     fetchdone:function(list_id){
      var vm = this;
        vm.$http.get('/getuser').then(function(response){
              
              var users = response.body.users;
              var pendings = response.body.pendings;
              var csrf_token = $('meta[name="csrf-token"]').attr('content');
              var alldata = [];
              var cards = [];
              var newarray = {};
               var count = new Array();
                users.forEach(function(user, value){
                var usercount = 0;
                 var retrieveSuccess = function(data) {
                  data.forEach(function(bx, bi){
                     var members = bx.idMembers;
                       members.forEach(function(member, value){
                          if(user.trelloId == member){
                              usercount++;
                              var actionSuccess = function(actiondata){
                                actiondata.forEach(function(action, data){
                                  if(action.type == "updateCard"){
                                          cards.push({"cardid": bx.id, "cardname": bx.name, "listid": bx.idList, "userid":member, "date_finished": action.date, "status": "Done", "url": bx.url})

                                    }
                                }); 
                                
                                var csrf_token = $('meta[name="csrf-token"]').attr('content');                              
                                  vm.$http.post('/setcards', {_token: csrf_token, sample: cards}, function(response) {
                                        alert(response);
                                  });
                              };
                              Trello.get("cards/"+bx.id+"/actions", actionSuccess);
                          }
                       });

                   });
                  
                  alldata.push({"name": user.name.split(" ")[0], "count": usercount});
                  
                  
                 };
                 
                
                  Trello.get("lists/"+list_id+"/cards", retrieveSuccess);

               
                });
                  
             /*     console.log(alldata);
                  console.log("test");
                  console.log(count);*/


                   }).catch(function(error){
        
                   });
                   //setTimeout(vm.fetchdone.bind(this), 6000);
             
          },

        fetchpending: function(){
          var vm = this;
              vm.$http.get('/getuser').then(function(response){
                 console.log('lists')
                var total = 0;
                var users = response.body.users;
               
              var pendings = [];
              var count = [];
                
              var retrieveSuccess = function(data){
                vm.getcards(data);
              };

            

              Trello.get("lists/"+list_id+"/cards", {fields: "id,name,displayName,idMembers"}, retrieveSuccess);


             

                   }).catch(function(error){
        
                   }); 
        }

   }

});
$( document ).ajaxSuccess(function() {
                console.log("ajaxComplete");
                 $( ".log" ).text( "Triggered ajaxComplete handler." );
    });
 window.addEventListener("load", function(event) {
    console.log("All resources finished loading!");
  });

function compressArray(original) {
 
    var compressed = [];
    // make a copy of the input array
    var copy = original.slice(0);
   
    // first loop goes over every element
    for (var i = 0; i < original.length; i++) {
   
      var myCount = 0;  
      // loop over every element in the copy and see if it's the same
      for (var w = 0; w < copy.length; w++) {
        if (original[i] == copy[w]) {
          // increase amount of times duplicate is found
          myCount++;
          // sets item to undefined
          delete copy[w];
        }
      }
   
      if (myCount > 0) {
        var a = new Object();
        a.value = original[i];
        a.count = myCount;
        compressed.push(a);
      }
    }
   
    return compressed;
};

function counter(count){
  count++;
  return count;
}
 
</script>

{{--  <script>
 new Vue({
    el: '#app2',
    name: 'test',
    data(){
        return{
              message:'',
              pendingtasks:[],
              }
        
      },

      mounted: function(){
          this.fetchPending()
      },methods:{
          fetchPending: function(){
            var vm = this;

            vm.$http.get('/test').then(function(response){
              //vm.pendingtasks = response.body.pendings;
            //  var name = response.body.pendings;
                    //vm.pendingtasks = response.body.pendings[0];
                    //console.log(vm.pendingtasks)
              //console.log(Object.keys(name));

              $.each(response.body.pendings[0], function(key, value){
                var firstname = key;
                var values = value;
                
                vm.pendingtasks.push({"name": firstname.split(" ")[0], "count": value});
                //console.log(key + " " + value);
              });
            });      
          }
      } 
  });
</script>  --}}

<!-- <script>
  new Vue({
    el: '#app3',
    name: 'test',
    data(){
        return{
              message:'',
              count:[]
              }
        
      },

      mounted: function(){
          this.fetchCount()
      },methods:{
          fetchCount: function(){
            var vm = this;

            vm.$http.get('/test').then(function(response){

              var name = response.body.daily;

              name.forEach(function(key, value){

                var firstname = key.name;

                vm.count.push({"name": firstname.split(" ")[0], "day": key.daily_count, "week": key.weekly_count, "month": key.monthly_count});

                console.log(vm.count);

              });

            });
          }
      }
    });
</script> -->
<script type="text/javascript"></script>

<script type="text/javascript">
  var time = setInterval(function(){
    if($('.taksss').length){
      $('#loading-wrapper').hide();
      clearInterval(time);
    }
  }, 1000)

</script>

@endsection