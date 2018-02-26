create or replace FUNCTION FN_SPLIT
(
p_list varchar2,
p_del varchar2 := ','
) RETURN split_tbl pipelined
IS
l_idx pls_integer;
l_list varchar2(32767) := p_list;

l_value  varchar2(32767);
BEGIN
loop                
l_idx := instr(l_list,p_del);
IF l_idx > 0 THEN                   
pipe ROW(substr(l_list,1,l_idx-1));
l_list := substr(l_list,l_idx+LENGTH(p_del));
ELSE
pipe ROW(l_list);
exit;
END IF;
END loop;
RETURN;
END FN_SPLIT;