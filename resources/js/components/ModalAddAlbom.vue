<template>
        <div class="wrap-modal" >
            <div class="modal-dialog">

                <div class="modal-content">

                    <!-- <input type="file" @change="ImageBased" class="form-control" id="input-file">-->
                    <div class="modal-header">
                        <div class="form-group">
                            <label  for="input-name">Название альбома  </label>
                            <input v-model="nameValue" name="name" class="form-control" type="text" id="input-name">
                        </div>
                        <button type="button" @click="$emit('close-modal')" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="input-description">Описание</label>
                            <input v-model="descriptionValue"  class="form-control" type="text" name="description" id="input-description">
                        </div>
                        <div class="form-check">
                            <input v-model="public" class="form-check-input" name="public" type="checkbox" value="" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Закрытый
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button v-if="!edited" class="btn btn-info" @click.prevent="SaveAlbom" >Добавить</button>
                        <button v-else class="btn btn-info" @click.prevent="EditAlbom" >Переименовать</button>
                    </div>



                </div>
            </div>
        </div>
</template>

<script>
    export default {
        name: "ModalAddAlbom",
        props: [
            'userid',
            'edited',
            'albomid',
            'editedName',
            'editedDescription'

        ],
        data(){
            return{
                nameValue: '',
                descriptionValue: '',
                imageSrc: '',
                public: false,
                userId: this.userid,
                albomId: this.albomid,
                editedName: this.editedName,
                editedDescription: this.editedDescription,

            }
        },
        methods:{
            SaveAlbom(){
                this.photoAlbom = {
                    name: this.nameValue,
                    description: this.descriptionValue,
                    public: 0
                };

                axios.post('http://photo-alboms/server.php/api/home',{name:this.nameValue,description: this.descriptionValue,public: 0,user_id: this.userId})
                    .then(res=> this.$emit('new-albom'));

            },
            EditAlbom(){
                this.photoAlbom = {
                    name: this.nameValue,
                    description: this.descriptionValue,
                    public: 0
                };

                axios.post(`/api/editAlbom/${this.albomId}`,{name:this.nameValue,description: this.descriptionValue,public: 0,user_id: this.userId})
                    .then(res=> this.$emit('new-albom'));

            },


        }
    }
</script>

<style scoped>
    .custom-modal{

        z-index: 10;
        background: #f8fafc;

    }
    .wrap-modal{
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1050;

        overflow: hidden;
        outline: 0;
        background: #0000006b;
    }
</style>
