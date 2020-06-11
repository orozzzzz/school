	class TabList {
  		constructor(buttonsContainer, tabs) {
    		this.buttonsContainer = buttonsContainer;
   		 	this.tabs = tabs;
    
		    this.buttonsContainer.addEventListener('click', event => {
		      try{
		        this.buttonsContainer.querySelector('.chosen').classList.remove('chosen');
		      }
		      catch(e){}
		      finally {
			      const index = event.target.closest('.sbutton').dataset.value;
			      event.target.closest('.sbutton').classList.add('chosen');
			      this.openTab(index);
		      }		      
		    });
  		}
  		openTab(index) {
	    this.tabs.querySelector('.active').classList.remove('active');
	    this.tabs.querySelector(`.tab--${index}`).classList.add('active');
  		}
	}

	document.addEventListener('DOMContentLoaded', ()=>{
	  const buttonsContainer = document.querySelector('.schoolhreflist');
	  const tabs             = document.querySelector('.schoolcontent');
	  const tabList = new TabList(buttonsContainer, tabs);
	})
