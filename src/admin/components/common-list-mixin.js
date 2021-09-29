import CustomPaginate from "./custom-paginate";

export default {
    data() {
        return {
            search: ""
        }
    },
    methods: {
        getCatFullTitle(id) {
            let cat = this.categories.filter(cat => cat.ID == id)[0];
            if (cat) {
                return cat.titulo;
            }
            return '--  --';
        },
        copyShortcode(e) {
            e.target.select();
            document.execCommand('copy');
            setTimeout(() => alert('Código copiado com successo para sua area de transfêrencia.'), 50)
        },
        handlerClick(page) {
            this.$router.push({
                name: this.$route.name,
                params: {
                    ...this.$route.params,
                    page
                },
                query: {
                    ...this.$route.query
                }
            });
        },
        handlerSearch() {
            this.$router.push({
                name: this.$route.name,
                params: {
                    ...this.$route.params,
                    page: 1                    
                },
                query: {
                    term: this.search
                }
            })
        },
        handlerRemove(key, item) {
            if (confirm('Remover o item selecionado?')) {
                this.removeItem({
                    ID: item.ID,
                    page: this.$route.params.page || 1
                });
            }
        },
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            vm.getItems({
                page: 1,
                ...to.params,
                ...to.query
            });
            
            vm.search = to.query.term;
        });
    },
    beforeRouteUpdate(to, from, next) {
        if (to.name == this.$route.name) {
            this.getItems({
                ...to.params,
                ...to.query
            });
        }
        next();
    },
    components: {
        CustomPaginate
    },
}