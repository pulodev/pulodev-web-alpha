export default class InfiniteScroll {
    constructor(rootElement,containerElement){
        this.rootElement = rootElement;
        this.containerElement = containerElement;
        this.triggerElement = containerElement.lastElementChild;
        this.getItems = () =>{};
        this.isLoading = false;
        this.observer = null;
        this.observing = false;
    }


    start(){
        const options = {
            root: this.rootElement,
            rootMargin: '0px',
            threshold: 1.0
          }
          
          this.observer = new IntersectionObserver((entries, observer) =>{
              this.trigger(entries,observer);
          }, options);
          this.observer.observe(this.triggerElement);
          this.observing = true;
          console.log('infinite scroll ready...');
    }

    async trigger(entries,observer){
        for (let i = 0; i < entries.length; i++) {
            const entry = entries[i];
            if (this.isLoading === false && entry.isIntersecting && entry.intersectionRatio >= 0.75) {
                //load the next page to container
                this.isLoading = true;
                this.observer.unobserve(this.triggerElement);
                this.containerElement.append(await this.getItems());
                this.triggerElement = this.containerElement.lastElementChild;
                if(this.observing)
                    this.observer.observe(this.triggerElement);
                this.isLoading = false;
            }
        }
            
          
    }
}

