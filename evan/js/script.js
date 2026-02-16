document.addEventListener('DOMContentLoaded', function(){
  var cta = document.getElementById('cta');
  if(cta){
    cta.addEventListener('click', function(){
      cta.classList.add('disabled');
      cta.innerText = 'Loading...';
      setTimeout(function(){
        cta.classList.remove('disabled');
        cta.innerText = 'Get Started Now';
        alert('This is a demo. Replace with your onboarding flow.');
      }, 900);
    });
  }
});
