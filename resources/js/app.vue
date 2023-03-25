<template>
    <div>
        <router-view v-slot="{ Component }">
            <transition name="nested" mode="out-in">
                <component :is="Component">
                </component>
            </transition>
        </router-view>
    </div>
</template>
  
<style>
.displayTrue {
    display: block !important;
}

.scrollContent {
    overflow-y: auto;
    height: 2500px;
    display: flex;
    flex-direction: column;
    overflow-x: hidden;
}

.proAni {
    overflow: hidden;
}

.nested-enter-active,
.nested-leave-active {
    transition: all 0.2s ease-in-out;
}

.nested-enter-active {
    transition-delay: 0.10s;
}

.nested-leave-active {
    transition-delay: 0.10s;
}

.nested-enter-from,
.nested-leave-to {
    /* transform: translateY(30px); */
    opacity: 0;
}

.nestedTop-enter-active,
.nestedTop-leave-active {
    transition: all 0.2s ease-in-out;
}

.nestedTop-enter-active {
    transition-delay: 0.10s;
}

.nestedTop-leave-active {
    transition-delay: 0.10s;
}

.nestedTop-enter-from,
.nestedTop-leave-to {
    transform: translateY(-30px);
    opacity: 0;
}

.nestedLeft-enter-active,
.nestedLeft-leave-active {
    transition: all 0.2s ease-in-out;
}

.nestedLeft-enter-active {
    transition-delay: 0.10s;
}

.nestedLeft-leave-active {
    transition-delay: 0.10s;
}

.nestedLeft-enter-from,
.nestedLeft-leave-to {
    transform: translateX(-30px);
    opacity: 0;
}


.nestedRight-enter-active,
.nestedRight-leave-active {
    transition: all 0.2s ease-in-out;
}

.nestedRight-enter-active {
    transition-delay: 0.10s;
}

.nestedRight-leave-active {
    transition-delay: 0.10s;
}

.nestedRight-enter-from,
.nestedRight-leave-to {
    transform: translateX(30px);
    opacity: 0;
}


.nestedBottom-enter-active,
.nestedBottom-leave-active {
    transition: all 0.2s ease-in-out;
}

.nestedBottom-enter-active {
    transition-delay: 0.10s;
}

.nestedBottom-leave-active {
    transition-delay: 0.10s;
}

.nestedBottom-enter-from,
.nestedBottom-leave-to {
    transform: translateY(30px);
    opacity: 0;
}



.nested-enter-active .innerTop,
.nested-leave-active .innerTop {
    transition: all 0.2s ease-in-out;
}

.nested-enter-active .innerTop {
    transition-delay: 0.10s;
}

.nested-enter-from .innerTop,
.nested-leave-to .innerTop {
    transform: translateY(-30px);
    opacity: 0.001;
}


.nested-enter-active .innerLeft,
.nested-leave-active .innerLeft {
    transition: all 0.2s ease-in-out;
}

.nested-enter-active .innerLeft {
    transition-delay: 0.10s;
}

.nested-enter-from .innerLeft,
.nested-leave-to .innerLeft {
    transform: translateX(-30px);
    opacity: 0.001;
}


.nested-enter-active .innerRight,
.nested-leave-active .innerRight {
    transition: all 0.2s ease-in-out;
}

.nested-enter-active .innerRight {
    transition-delay: 0.10s;
}

.nested-enter-from .innerRight,
.nested-leave-to .innerRight {
    transform: translateX(30px);
    opacity: 0.001;
}

.nested-enter-active .innerBottom,
.nested-leave-active .innerBottom {
    transition: all 0.2s ease-in-out;
}

.nested-enter-active .innerBottom {
    transition-delay: 0.10s;
}

.nested-enter-from .innerBottom,
.nested-leave-to .innerBottom {
    transform: translateX(30px);
    opacity: 0.001;
}



</style>