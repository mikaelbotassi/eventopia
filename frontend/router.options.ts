import type { RouterConfig } from "nuxt/schema";
import { createMemoryHistory } from "vue-router";

export default <RouterConfig> {
    history: base => process.client ? createMemoryHistory(base) : null,
    scrollBehaviorType: 'smooth'
}