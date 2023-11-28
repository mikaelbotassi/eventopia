export function cast(target:any, source:any) {
    for (const key in target) {
      if (source.hasOwnProperty(key)) {
        target[key] = source[key];
      }
    }
    return target
}  