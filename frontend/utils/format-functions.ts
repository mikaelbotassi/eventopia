export function formatarDataHoraMinuto(dateString:string) {
  const date = new Date(dateString);
  const options:any = { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' };
  const formato = new Intl.DateTimeFormat('pt-BR', options);
  
  return formato.format(date);
}