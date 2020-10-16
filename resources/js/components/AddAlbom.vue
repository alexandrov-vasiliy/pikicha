<template>
    <div class="mb-5  custom-modal ">
        <div class="btn btn-info " @click="modal">{{btnText}}</div>


    </div>

</template>

<script>
    export default {
        name: "AddAlbom",
        props: [
            'userid'
        ],
        data() {
            return{
                showModal: false,
                btnText: 'Добавить альбом',
                /*nameValue: '',
                descriptionValue: '',
                imageSrc: '',
                public: false,*/
                userId: this.userid,
            }
        },
        methods:{

                modal(){

                    if(this.showModal){
                        this.btnText = 'Добавить альбом';
                    }else

                    this.showModal=!this.showModal;
                },



        }

    }

</script>

<style scoped>


</style>
