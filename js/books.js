export default class Books {
    constructor() {
        this.data = {
            password: 'Swordfish666'
        }

        this.rootElement = document.querySelector('.books');
        this.filter = this.rootElement.querySelector('.filter');
        this.items = this.rootElement.querySelector('.items');
    }

    async init() {
        await this.render();
    }

    async render() {
        const data = await this.getData();

        const row = document.createElement('div');
        row.classList.add('row', 'g-4');

        for (const item of data) {
            const col = document.createElement('div');
            col.classList.add('col-md-6', 'col-lg-4', 'col-xl-3');

            col.innerHTML = `
               <div class="card">
                   <img src="uploads/${item.coverImageURL}" class="card-img-top" alt="...">
                   <div class="card-body">
                       <h5 class="card-title">${item.bookName}</h5>
                       <p class="card-text">${item.bookText}</p>
                       <a href="#" class="btn btn-primary text-white w-100">Go somewhere</a>
                   </div>
               </div>`;
            row.appendChild(col);
        }
        this.items.appendChild(row);
    }

    async getData() {
        const response = await fetch('api.php', {
            method: 'POST',
            body: JSON.stringify(this.data)
        });
        return await response.json();
    }
}
