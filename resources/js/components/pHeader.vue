<template>
    <div class="header">
        <div class="bread-crumb" :key="key">
            <div v-for="(item, index) in breadCrumb" :key="index">
                <i class="el-icon-arrow-right" v-if="index !== 0"></i>
                <span
                class="pointer"
                @click="changePathByBreadCrumb(item)"
                :class="(breadCrumb.length == index+1) ? 'text-primary' : ''"
                >{{ item.name }}</span>
            </div>
        </div>
    </div>
</template>

<script>
import {ArrowRightIcon} from 'vue-feather-icons'
    export default {
        name: 'pHeader',
        components: {
            ArrowRightIcon
        },
        props: ['frontdeskProp'],
        data(){
            return {
                key: 0,
                breadCrumb: [  ],
                breadCrumb_Init: [
                    { name: "Home", route_name: "/", value: "home", index: 0 },
                    {
                        name: this.frontdeskProp ? "Frontdesk" : "Administration",
                        route_name: this.frontdeskProp ? "frontdesk-dashboard" : "dashboard",
                        value: "rk-admin",
                        index: 1,
                    },
                ],
            }
        },
        watch: {
            $route(to) {

                this.breadCrumb = [...this.breadCrumb_Init]
                console.log({ to });
                let i = 2
                to.matched.filter(t=> t.name &&t.name != 'Home' && t.name.length > 2).forEach(element => {
                    this.breadCrumb[i] = { name: this.formatName(element.name), route_name: element.name, index:i }
                    i++
                });
                this.$forceUpdate()
                console.log(this.breadCrumb)
               
            },
        },
        methods: {
            changePathByBreadCrumb(val) {
                if (val.value === "home") {
                    this.goToHome();
                } else if ((val.value = "rk-admin")) {
                    if (this.$route.name != val.route_name)
                    this.$router.push({ name: val.route_name });
                } else {
                    if (this.$route.name != val.name) this.$router.push({ name: val.name });
                }
            },
            formatName(name){
                return name.split("-").join(" ")
            },
            goToHome(){
                this.$router.push({
                    name: 'home'
                })
            }

        },
        beforeMount() {
            this.breadCrumb = this.breadCrumb_Init
            if(!this.breadCrumb.some(b=>b.route_name === this.$route.name))
                this.breadCrumb[2] = { name: this.formatName(this.$route.name), route_name: this.$route.name, index:2 }
            
            
        },
    }
</script>

<style lang="scss" scoped>
.header {
  background: white;
  display: flex;
  align-items: center;
  border-bottom: 1px solid #e6e6e6;
  height: 70px;
  border-top-left-radius: 10px;
    border-top-right-radius: 10px;

    .bread-crumb {
        flex: 1;
        display: flex;
        align-items: center;
        padding: 10px 20px;
        font-size: 14px;
        text-transform: capitalize;
        span {
            font-weight: 600;
        }
        i {
            margin: 0 5px;
        }
        .active {
            color: #999;
        }
    }
}
</style>