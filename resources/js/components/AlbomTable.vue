
<template>

    <div class="card-body" @contextmenu.prevent="ContextMenu"  @click="HideContextMenu">
        <modal-add-albom  v-if="showModal" @close-modal="modal" @new-albom="getAlboms"
                          :userid="user_id"
                          :edited="modalEdite"
                          :albomid="albomContextId"

        ></modal-add-albom>
        <div class="alboms" id="albom-table">
            <div v-for="albom in alboms" :data-ctx="albom.id" class="albom__item">



                <img   class="albom__img w-100 " :data-ctx="albom.id" src="/images/albom-label.png" alt="">
                <div class="albom__body" :data-ctx="albom.id">

                    <h2 class="albom__title" :data-ctx="albom.id">{{albom.name}}</h2>
                    <span class="albom__description ctx"  :data-ctx="albom.id"  >{{albom.description}}</span>

                </div>

            </div>

        </div>
        <transition name='fade'>
            <div v-show="showMenu"
                 :style="{top: contextTop + 'px', left: contextLeft + 'px'}"


                 class="custom-context-menu isHideContext" id="context-menu">
                <div class="menu__item" @click="modal" >Добавить новый альбом</div>
                <div class="menu__item" >Добавить закрытый альбом</div>
                <!--<a class="menu__item" href="#">Something else here</a>-->
            </div>
        </transition>
        <transition name='fade'>
            <div v-show="showMenuAlboms"
                 :style="{top: contextTop + 'px', left: contextLeft + 'px'}"


                 class="custom-context-menu isHideContext" id="context-menu-albom">
                <div class="menu__item" @click="removeAlbom(albomContextId)" >удалить</div>
                <div class="menu__item" @click="editAlbom" >переиминовать</div>
                <!--<a class="menu__item" href="#">Something else here</a>-->
            </div>
        </transition>

    </div>

</template>

<script>

    export default {
        props: [
            'userid'
        ],
        name: "AlbomTable",
        data(){
            return{
                user_id: this.userid,
                alboms: [

                ],
                showMenu: false,
                showMenuAlboms: false,
                menuClass: false,
                showModal: false,
                contextTop: 0,
                contextLeft: 0,
                albomContextId: '',
                modalEdite:false,

            }
        },
        methods:{
            getAlboms(){
                this.showModal = false;
                axios.get(`/api/getAlbom/${this.user_id}`)
                    .then(response => this.alboms = response.data);



            },

            ContextMenu(e){
                let t = e.target;
                console.log(e);

                if(t.id === 'albom-table' ) {
                    this.modalEdite = false;
                    this.showMenuAlboms = false;

                    this.contextTop = e.offsetY + 70;
                    this.contextLeft= e.offsetX + 20;

                    /*$('#context-menu').css({

                        top: top,
                        left: left
                    });*/
                    this.showMenu = true;
                }else{
                    console.log(e.target.parentElement);

                    this.showMenu = false;
                    this.contextTop  = e.pageY - 70;
                    this.contextLeft = e.pageX - 390;
                    this.showMenuAlboms = true;

                    let td = e.target.closest('.albom__item');
                    if(td){
                        let data = e.target.dataset.ctx;
                        this.albomContextId = data;
                        console.log('клик по итему ' + data);
                    }else {
                        console.log('клик по столу')
                    }

                }
            },
            HideContextMenu(){
                if(this.showMenu || this.showMenuAlboms)
                setTimeout(()=>{
                    this.showMenuAlboms = false;
                    this.showMenu = false
                },100);
                /*setTimeout(()=>this.showMenu = false,1000);*/
                    //this.menuClass = '';


            },
            ContextAlbom(e){
                this.contextTop = e.pageYOffset + 70;
                this.contextLeft= e.pageXOffset + 20;
                this.showMenuAlboms = true;
            },
            modal(){
                /*if(!this.showModal)
                    this.showModal=true;
                if(this.showModal){
                    this.showModal = false;
                }*/
                this.showModal = !this.showModal;
            },
            removeAlbom(albomId){
                axios.post(`/api/removeAlbom/${albomId}`)
                    .then(res=> console.log(res));
                this.showMenuAlboms = false;
                setTimeout(this.getAlboms(), 200);

            },
            editAlbom(){
                this.showModal = true;
                this.modalEdite = true;
            }



        },
        created() {
            this.getAlboms();
        }


    }


</script>

<style scoped>

#albom-table{
    min-height: 60vh;
}
.albom__item{
    max-width: 10rem;
    text-align:center;
    padding: 20px;
    cursor: pointer;
}

.albom__item:hover{
    background-color: rgba(0,0,0,.05);
}
.alboms{
    display:grid;
    grid-template-columns: repeat(5, 1fr);
    grid-template-rows: repeat(2, 1fr);
    justify-items: center;
    align-items:center;
}
.albom__title{
    font-size: 14px;
}
.albom__description{
    font-size: 12px;
}
.custom-context-menu{
    position: absolute;
    background-color: #fff;
    display: flex;
    flex-direction:column;

    padding: 0px;
    width: 20rem;
    border-radius: 4px;
    box-shadow: 0 10px 20px -5px rgba(0,0,0,.4);

}
.menu__item{
    padding: 10px;

    background-color: #fff;
    color: #000;
    font-size: 18px;
    cursor: pointer;
}
.menu__item:hover{
    background-color: #555;
    color: #fff;
}

.fade-enter-active, .fade-leave-active {
    transition: .2s;

}
.fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
    opacity: 0;
    transform: translateY(20px);
}

</style>
