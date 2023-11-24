<template>
  <div class="my-modal-footer">
      <slot></slot>
  </div>
</template>

<style>
  .my-modal-footer{
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 1rem;
      border-top: 1px solid rgba(255,255,255,.25);
      padding: 1.5rem;
  }
</style>