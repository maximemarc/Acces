net group "GG_RW_1" /add  
net localgroup "GL_RW_1" /add 
net group "GG_RO_1" /add 
net localgroup "GL_RO_1" /add 
net localgroup "GL_RO_1" "GG_RO_1" /add 
net localgroup "GL_RW_1" "GG_RW_1" /add 
