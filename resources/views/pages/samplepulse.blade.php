<style type="text/css">
	/* Enter and leave animations can use different */
/* durations and timing functions.              */
.slide-fade-enter-active {
  transition: all .3s ease;
}
.slide-fade-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}

.element {
  animation: pulse 5s infinite;
}

@keyframes pulse {
  0% {
    background-color: #001F3F;
  }
  100% {
    background-color: #FF4136;
  }
}


.pulse{
  
}
.pulse-active {
  &::before {
    content: '';
    display: block;
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background-color: blue;
    border-radius: inherit;
    transition: opacity .3s, transform .3s;
    animation: pulse-animation 2s cubic-bezier(0.24, 0, 0.38, 1) 1;
    z-index: -1;
  }


  overflow: visible;
  position: relative;
}

@keyframes pulse-animation {
  0% {
    opacity: 1;
    transform: scale(1);
  }
  50% {
    opacity: 0;
    transform: scale(1.5);
  }
  100% {
    opacity: 0;
    transform: scale(1.5);
  }
}

</style>

<div id="app">
  <transition name="pulse">
    <p v-if="show" id="changeText">it changed</p>
  </transition>
</div>

<p class="pulse-active" id="test">Text</p>
<button id="submit1">change</button>

 <script src="js/app.js"></script>

<script>
  new Vue({
  el: '#app',
  data: {
    show: true
  },
  mounted: function(){
    this.load()
  },
  methods:{
    load: function(){
      var vm = this;
      var text = ["Welcome", "Hi", "Sup dude"];
      var counter = 0;
      var elem = document.getElementById("changeText");
      var test = $('#changeText');
      setInterval(change, 5000);
     
      function change() {
        elem.innerHTML = text[counter];
        counter++;
        if (counter >= text.length) {
          counter = 0;
        }
       
      }
      this.observer = new MutationObserver( function(mutations) {
          vm.show = false;
        
      }.bind(this));
      this.observer.observe(test.get(0), {characterData: true, childList: true});
      vm.show = true;
    }
  }
})
</script>

<script type="text/javascript">
  $(function(){
      //Store the test paragraph node

      
      //Function to change the paragraph
     
</script>