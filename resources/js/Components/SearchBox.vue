<template>
    <div>
        <span class="p-input-icon-right">
            <i class="pi pi-search" />

            <InputText type="text" v-model="searchKey" placeholder="Search" />
        </span>
    </div>
</template>

<script setup>
import { watch,ref, computed, toRefs } from "@vue/runtime-core";
import {debounce} from "lodash";
import {router} from '@inertiajs/vue3';

  const props=defineProps({model:String})
  const {model}= toRefs(props)
  const emit =defineEmits('loadMembers');
  let items=null
  let searchKey=ref('')
//   const getRoute=computed(()=>route(`${props.model}'.index'`))
  watch(searchKey,debounce((value)=>{
                                            //   alert(value)
                                    router.get(model.value,{'search':value},{preserveState:true,replace:true})
                                    },300));

</script>

<style lang="scss" scoped>

</style>
