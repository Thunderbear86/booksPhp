export default class Users {
    constructor() {
        this.rootElement = document.querySelector('.users');
    }

    init() {
        this.render();

    }

    async render() {
        const data = await this.getData();

        const row = document.createElement('div');
        row.classList.add('row');

        for (const item for data) {
            const col = document.createElement('div');
            col.classList.add('col-6');

            col.innerHTML = `
               <div class="card">
                   <div class="card-body">
                       <p class="card-title">${item.name}</p>
                       <p class="card-title">${item.age}</p>
                   </div>
               
               
               ${item.favoriteColor.map(color => {
                return `<p>${color}</p>`;
            }).join('')}
               
                  ${Object.entries(item.hobbies).map(([hobby, l]) => {
                return `<p>${hobby} : {l}</p>`;
            }).join('')}
               
               </div>
               
           `;
            row.appendChild(col);
        }

        this.rootElement.appendChild(row);

    }
}

async
getData()
{
    const respons = await fetch('users.json');
    return await respons.json();

}