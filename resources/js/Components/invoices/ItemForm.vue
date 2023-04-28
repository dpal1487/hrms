<script>

import { defineComponent } from 'vue';

export default defineComponent({
    props: ["id", "count", "index", 'form' , 'item'],
    emits: ["removeSingle"],

})


</script>


<template>
    
    <!-- {{ form.name[index] }} -->
    <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
        <td>
            
            <input type="text" class="form-control form-control-solid mb-2" v-model="form.name[index]"
                :name="`index[${index}]name`" placeholder="Item name" />
        </td>
        <td> <input type="text" class="form-control form-control-solid" v-model="form.cpi[index]" :name="`index[${index}]cpi`"
                placeholder="Description" />
        </td>
        <td class="ps-0">
            
            <input class="form-control form-control-solid" type="number" v-model="form.quantity[index]"
                :name="`index[${index}]qunatity`" placeholder="1" />
        </td>
        <td>
            <input type="text" class="form-control form-control-solid text-end" v-model="form.price[index]"
                :name="`index[${index}]price`" placeholder="0.00" />
        </td>
        <td class="pt-8 text-end text-nowrap">
            {{ totalPrice = ( form.quantity[index] * form.price[index] )}} 
             <input type="text" class="form-control form-control-transparent text-end p-0" v-model="totalPrice" 
                    :name="`index[${index}]price`" placeholder="0.00" />
            <!-- <span data-kt-element="total" > {{ totalPrice }}</span> -->
        </td>
        <td class="pt-5 text-end">
            <button :disabled="count <= 1" type="button" class="btn btn-sm btn-icon btn-active-color-primary"
                @click="$emit('removeSingle', {id: this.id, index: index})">
                <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                            fill="currentColor" />
                        <path opacity="0.5"
                            d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                            fill="currentColor" />
                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                            fill="currentColor" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </button>
        </td>
    </tr>
</template>
