//
//  ViewController.m
//  hero-password-keeper
//
//  Created by SoEasY on 17/04/2021.
//

#import "ViewController.h"
#import "random.h"

@interface ViewController ()

@end

@implementation ViewController

- (IBAction)forgot:(id)sender {
    UIAlertController *alertController = [UIAlertController alertControllerWithTitle:@"Good luck" message:@"\nGood luck buddy ¯\\_(ツ)_/¯" preferredStyle:UIAlertControllerStyleAlert];
    [alertController addAction:[UIAlertAction actionWithTitle:@"SERIOUSLY ??!!!" style:UIAlertActionStyleDefault handler:nil]];
    [self presentViewController:alertController animated:YES completion:nil];
    
}

- (IBAction)logMe:(id)sender {
    
    if ([[dico objectForKey:usernameField.text] isEqualToString:passordField.text]) {
        UIAlertController *alertController = [UIAlertController alertControllerWithTitle:@"Good password" message:@"\nYou found the good password ! But you didn't store anything here ¯\\_(ツ)_/¯" preferredStyle:UIAlertControllerStyleAlert];
        [alertController addAction:[UIAlertAction actionWithTitle:@"NICEEE" style:UIAlertActionStyleDefault handler:nil]];
        [self presentViewController:alertController animated:YES completion:nil];
    
    }else{
        UIAlertController *alertController = [UIAlertController alertControllerWithTitle:@"Wrong password" message:@"\nWrong password !\nI hope you didn't forget your credentials ¯\\_(ツ)_/¯" preferredStyle:UIAlertControllerStyleAlert];
        [alertController addAction:[UIAlertAction actionWithTitle:@"Sh*t" style:UIAlertActionStyleDefault handler:nil]];
        [self presentViewController:alertController animated:YES completion:nil];
    }
    
}

- (void)viewDidLoad {
    [super viewDidLoad];
    
    NSString *p = @"Sw4gGP4ssw0rd";
    NSString *pp = [p GetRandomNumberBetween1and10];
    NSString *ppp = [p stringByAppendingString:@"-"];
    NSString *pppp = [ppp stringByAppendingString:pp];
    
    NSString *u = @"eFhENHJLX0szdjFuWHg=";
    NSData *uu = [[NSData alloc] initWithBase64EncodedString:u options:0];
    NSString *uuu = [[NSString alloc] initWithData:uu encoding:NSUTF8StringEncoding];
    
    dico = [NSDictionary dictionaryWithObjects:[NSArray arrayWithObjects:pppp, nil] forKeys:[NSArray arrayWithObjects:uuu, nil]];
    // Do any additional setup after loading the view.
}


@end
