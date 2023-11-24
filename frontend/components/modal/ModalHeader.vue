<template>
  <div class="my-modal-header">
      <slot></slot>
  </div>
</template>

<style>
  .my-modal-header{
      display: flex;
      align-items: center;
      justify-content: space-between;
      color: var(--dark);
      fill: var(--dark);
      font-weight: bold;
      font-size: 1.25rem;
      background-color: var(--secondary);
      padding: 1.5rem;
  }
</style>