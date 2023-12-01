export default class CsvButton {
    filters: [];
    label: string;
    icon: any;
  
    constructor(filters: [], label: string, icon: any) {
      this.filters = filters;
      this.label = label;
      this.icon = icon;
    }
}