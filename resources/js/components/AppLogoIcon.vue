<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" :class="className" v-bind="$attrs">
        <sodipodi:namedview id="namedview1" pagecolor="#ffffff" bordercolor="#000000" borderopacity="0.25" />
        <defs id="defs1" />
  <g
     inkscape:label="Слой 1" inkscape:groupmode="layer" id="layer1">
    <rect
       style="fill:#000000;stroke:#000000;stroke-width:0.2"
       id="rect1" width="20" height="20" x="4.0" y="4.0" />
    <path
       sodipodi:type="star" style="fill:#00CC00;stroke:#00ff00;stroke-width:0.2" id="path1" inkscape:flatsided="true" sodipodi:sides="3"
       sodipodi:cx="6.9239264" sodipodi:cy="8.0171776" sodipodi:r1="9.1104298" sodipodi:r2="4.5552149" sodipodi:arg1="0" sodipodi:arg2="1.0471976"
       inkscape:rounded="0" inkscape:randomized="0" d="m 16.034356,8.0171776 -13.6656445,7.8898634 0,-15.77972703 z"
       inkscape:transform-center-x="-1.6802295" transform="matrix(0.7377169,0,0,0.81963262,5.7050952,8.3699637)" />
    <path
       sodipodi:type="star" style="fill:#00C000;stroke:#00ff00;stroke-width:0.2" id="path1-8"
       inkscape:flatsided="true" sodipodi:sides="3" sodipodi:cx="6.9239264" sodipodi:cy="8.0171776"
       sodipodi:r1="9.1104298" sodipodi:r2="4.5552149" sodipodi:arg1="0" sodipodi:arg2="1.0471976"
       inkscape:rounded="0" inkscape:randomized="0" d="m 16.034356,8.0171776 -13.6656445,7.8898634 0,-15.77972703 z"
       inkscape:transform-center-x="0.22513469" transform="matrix(0.49577472,-0.27843962,0.34330489,0.49202917,12.770144,7.3033838)"
       inkscape:transform-center-y="1.2683524" />
  </g>
    </svg>
</template>
