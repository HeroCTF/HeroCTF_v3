use std::fs;
use std::env;

static KEY: [usize; 47] = [0xa3, 0xdd, 0x41, 0xf6, 0x31, 0x9, 0x27, 0x31, 0x2b, 0x3e, 0x2, 0x76, 0x2c, 0x16, 0x33, 0x7b, 0x39, 0x12, 0x25, 0x21, 0x60, 0x26, 0xd, 0x67, 0x36, 0x65, 0x23, 0x23, 0x7, 0xb, 0x2f, 0x6e, 0x28, 0x2, 0x2c, 0x6c, 0x16, 0x52, 0x10, 0x10, 0x55, 0xb, 0x1, 0x58, 0x57, 0x14, 0x60];

fn main() {
    let args: Vec<String> = env::args().collect();

    match args.len() {
        1 => {
            println!("Nope.");
        },
        2 => {
            println!("Nope.");
        },
        3 => {

            let number: usize = match args[1].parse() {
                Ok(60) => 60,
                _ => 42
            };

            let filename:&str = &args[2];

            let buff = fs::read_to_string(filename)
                .expect("/!\\ FILE NOT FOUND /!\\");

            let buf = buff.chars();
            let _len = buff.chars().count();
            let mut ret = true;

            if &args[1] != "60" {
                ret = false;

            }else if buff.chars().count() != 47 {
                ret = false;
            
            }else{
                for (i, c) in buf.enumerate(){
                    if i == 0{
                        if c != 'F'{
                            ret = false;
                        }
                    }else if i == 1{
                        if c != 'L'{
                            ret = false;
                        }
                    }else if i == 2{
                        if c != 'A'{
                            ret = false;
                        }
                    }else if i == 3{
                        if c != 'G'{
                            ret = false;
                        }
                    }else if i == 4{
                        if c != '='{
                            ret = false;
                        }
                    }else{
                        if KEY[i] != c as usize ^ (i+number){
                            ret = false;
                        }
                    }
                }
            }

            if ret == true{
                println!("Good job !");
            }else{
                println!("Nope.");
            }
        },
        _ => {
            println!("Nope.");
        }
    }
}