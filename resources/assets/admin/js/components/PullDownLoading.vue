<template>
    <div>
        <slot :data="list"></slot>
        <load-more v-if="loading && !isEnd" tip="正在加载"></load-more>
        <load-more v-if="isEnd" background-color="#f5f5f5" :show-loading="false" tip="已到底部了"></load-more>
    </div>
</template>

<script>
    import { LoadMore } from 'vux';
    export default {
        components: { LoadMore },
        props: {
            query: String,
            perPage: String,
            addedParams: Object,
            manual: Boolean
        },
        data () {
            return {
                list: [],
                currentPage: 0,
                loading: false,
                isEnd: false
            }
        },
        methods: {
            update () {
                this.list = [];
                this.currentPage = 0;
                this.getList(true);
                this.isEnd = false;
            },
            getList (noConcat) {
                let params = {
                    page: ++this.currentPage,
                };
                if(this.perPage){
                    params.per_gage = this.perPage;
                }
                this.$http.get(this.query, { params: Object.assign(params, this.addedParams) }).then(res => {
                    this.$emit('on-class-name', res.data.meta.department_class_name);
                    if (res.data.meta.pagination.count < res.data.meta.pagination.per_page) {
                        this.isEnd = true;
                    }else{
                        this.loading = false;
                    }
                    if(res.data.meta.pagination.count != 0){
                        if(noConcat){
                            this.list = res.data.data;
                        }else{
                            this.list = this.list.concat(res.data.data);
                        }
                    }
                })
            }
        },
        mounted () {
            window.onscroll = (e) => {
                let scrollTop = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop
                if (document.documentElement.scrollHeight === document.documentElement.clientHeight + scrollTop) {
                    if (!this.isEnd) {
                        this.loading = true;
                        this.getList();
                    }
                }
            };
            if(!this.manual){
                this.getList()
            }
        }
    }
</script>