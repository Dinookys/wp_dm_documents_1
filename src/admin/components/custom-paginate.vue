<template>
    <div class="tablenav" v-if="pageCount > 1" >
        <paginate
            v-model="page"
            :force-page="forcepage"
            :page-count="pageCount"
            :click-handler="clickHandler"
            container-class="tablenav-pages"
            page-class="tablenav-pages-navspan button"
            prev-class="tablenav-pages-navspan button"
            next-class="tablenav-pages-navspan button"
            prev-text="&lsaquo;"
            next-text="&rsaquo;"
        ></paginate>
    </div>
</template>

<script>
import Paginate from 'vuejs-paginate'

export default {
    props: {
        pageCount: {
            type: Number,
            default: 20
        },
        clickHandler: {
            type: Function,
            default: () => {}
        }
    },
    data() {
        return {
            page: 1,
            forcepage: 1
        }
    },
    components: {
        Paginate
    },
    mounted() {
        if(this.$route.params.page && this.page != this.$route.params.page ) {
            this.page = Number(this.$route.params.page);
            this.forcepage = Number(this.$route.params.page);
        }
    }
}
</script>

<style>

</style>