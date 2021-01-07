<template>
    <div :class="{'opened-select' : opened}" class="select-container" :selected-id="selected[keyTitle]">
        <span v-if="title" class="bold input-title flex">{{ title }}</span>
        <div @click="open" :class="searchable ? '' : 'top-padding-select'" class="select-box flex align-between">
            <span v-if="searchable" class="selected-item">
                <input :placeholder="placeholder" class="top-padding-select" v-model.trim="searchValue" type="text" >
            </span>
            <span v-else class="selected-item">
                {{ selected[textTitle] || placeholder }}
            </span>
            <div class="arrow">
                <svg class="flex" width="8" height="5" viewBox="0 0 8 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.64645 4.35355C3.84171 4.54882 4.15829 4.54882 4.35355 4.35355L7.53553 1.17157C7.7308 0.976311 7.7308 0.659728 7.53553 0.464466C7.34027 0.269204 7.02369 0.269204 6.82843 0.464466L4 3.29289L1.17157 0.464466C0.976311 0.269204 0.659728 0.269204 0.464466 0.464466C0.269204 0.659728 0.269204 0.976311 0.464466 1.17157L3.64645 4.35355ZM3.5 3L3.5 4L4.5 4L4.5 3L3.5 3Z" fill="#5A636B"/>
                </svg>
            </div>
        </div>
        <ul class="options-list">
            <!-- <li class="empty"></li> -->
            <li v-if="!items.length">{{ emptyLabel || 'Нема вибору' }}</li>
            <li v-if="searchable" v-for="item of searched"
            :key="item[keyTitle]"
            @click="select(item)"
            v-bind="$attrs">
                {{ item[textTitle].trim() }}
            </li>
            <li v-if="!searchable" v-for="item of items"
            :key="item[keyTitle]"
            @click="select(item)"
            v-bind="$attrs">
                {{ item[textTitle].trim() }}
            </li>
        </ul>
        <span class="error-text flex" v-if="error">
            {{ error }}
        </span>
    </div>
</template>

<script>
export default {
    data: function () {
        let selectedText = '';

        if (Object.keys(this.selectedItem || {}).length > 0) {
            selectedText = (this.selectedItem[this.textTitle] || '').trim()
        }

        return {
            opened: false,
            selected: this.selectedItem || [],
            searchValue:  selectedText,
        }
    },
    model: {
        event: 'click'
    },
    props: {
        placeholder: {
            type: String,
            default: ''
        },
        emptyLabel: {
            type: String,
            default: ''
        },
        isId: {
            type: Boolean,
            default: false
        },
        items: {
            type: Array,
            default: () => ([])
        },
        keyTitle: {
            type: String,
            default: 'id'
        },
        searchable: {
            type: Boolean,
            default: false
        },
        textTitle: {
            type: String,
            default: 'title'
        },
        selectedItem: {
            type: [Object, String, Number],
            default: () => ({}) 
        },
        error: {
            type: String,
            default: ''
        },
        title: {
            type: String,
            default: ''
        }
    },
    methods: {
        open() {
            this.opened = !this.opened ? true: false;
        },
        select(item) {
            if (this.isId) {
                this.$emit('click', item[this.keyTitle]);
            }
            else {
                this.$emit('click', item);
            }

            this.$emit('on-select', item);
            this.selected = item;
            this.opened = false;
            this.searchValue = item[this.textTitle].trim();
        },
        close(event) {
            if (!this.$el.contains(event.target)) {
                this.opened = false
            }
        }
    },
    computed: {
        searched () {
            return this.items.filter(item => {
                if (item[this.textTitle].toLowerCase()
                .indexOf(this.searchValue.toLowerCase()) !== -1) {
                    return item;
                }
            })
        }
    },
    mounted: function () {
        document.addEventListener('click', this.close);
    },
    created: function () {
        if (typeof this.selectedItem == "object") {
            if (Object.keys(this.selectedItem || {}).length > 0) {
                if (this.selectedItem[this.keyTitle] != null)
                    this.$emit('on-select', this.selectedItem);
            }
        }
        else if (typeof this.selectedItem == "string" || typeof this.selectedItem == "number") {
            for(const elem of this.items) {
                if (elem[this.keyTitle] == this.selectedItem) {
                    this.selected = elem;
                    this.$emit('on-select', this.selectedItem);
                }
            }
        }
    }
}
</script>

<style scoped>
.top-padding-select {
    padding-top: 16px;
    padding-bottom: 16px;
}

input {
    width: 100%;
}

.input-title {
    /* margin-left: 20px; */
    padding: 3px 20px;
}

.select-container {
    position: relative;
    /* z-index: 3; */
}

.error-text {
    color: #DB3636;
    font-weight: bold;
    margin-left: 20px;
    opacity: 0;
    transition: .3s;
    margin-top: 5px;
    visibility: hidden;
}

.invalid .error-text {
    opacity: 1;
    visibility: visible;
}

.invalid-notext .select-box {
    border-color: #DB3636;
}

.select-box {
    transition: .3s;
    font-family: Roboto-light;
    position: relative;
    border: 1px solid #CFCFCF;
    border-radius: 50px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-left: 20px;
    padding-right: 20px;
    cursor: pointer;
    background: #fff;
    width: 100%;
    /* z-index: 999; */
}

.empty {
    padding: 13px 0 !important;    
}

/* .options-list li:not(:first-child):hover {
    background: #FFE300;
} */

.options-list li:hover {
    background: #FFE300;
}

.options-list li {
    transition: .2s;
    user-select: none;
    padding: 10px 20px;
}

.options-list {
    max-height: 300px;
    transform-origin: top center;
    transform: scaleY(0);
    position: absolute;
    overflow: auto;
    width: 100%;
    /* top: 35px; */
    cursor: pointer;
    border-radius: 10px;
    transition: .2s;
    z-index: 998;
    background: #fff;
}

.opened-select .options-list {
    transform: scaleY(1);
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.07);
}

.arrow {
    transition: .2s;
    user-select: none;
}

.opened-select .arrow {
    transform: rotate(180deg);
}

.selected-item {
    width: 100%;
    height: 100%;
    user-select: none;
}
</style>
