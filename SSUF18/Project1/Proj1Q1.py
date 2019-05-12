#############################################################################
# Authors : John Salman, Jeff Olson, Ian Davidson                           #
# Assignment: Project 1, Problem 1                                          #
# Class: CS454 Theory of Computation                                        #
# Date: Sept 23, 2018                                                       #
#############################################################################

import sys
import numpy as np
from sympy import pprint
sys.displayhook = pprint
from numpy.linalg import matrix_power
from sympy import * # have sympy installed locally
import sympy as sp
from collections import deque
# init_printing(use_unicode=True)
# sympy is not installed on blue so someone will have to download this package locally and get it working from there. 

#sympy library, one with abitrary percision

#input: number of inputs left
#currentState: refers to the state index in transitions we are to

def problem1():
    
    inputSize = input("Please enter a value between 1 and 300 for the size of input (-1 to quit): ")
    if (inputSize == -1):
        print("Have a great day!")
        sys.exit(0)
    while (inputSize < 1 or inputSize > 300):  
        inputSize = input("Please enter a value between 1 and 300 for size of the input (-1 to quit): ")
   
    #row index: the state number
    #columns: (0,1,2) => input: (a,b,c)
    transitions = [[1,2,3],#start (empty)
        [4,5,6],#a
        [7,8,9],#b
        [10,11,12], #c
        [37,13,14], #aa
        [15,16,17], #ab
        [18,19,20], #ac
        [21,22,23], #ba
        [24,37,25], #bb
        [26,27,28], #bc
        [29,30,31], #ca
        [32,33,34], #cb
        [35,36,37], #cc
        [37,37,17], #aab
        [37,19,37], #aac
        [37,37,23], #aba
        [37,37,25], #abb
        [26,27,28], #abc
        [37,30,37], #aca
        [32,33,34], #acb
        [37,36,37], #acc
        [37,37,14], #baa
        [37,37,17], #bab
        [18,19,20], #bac
        [37,37,23], #bba
        [26,37,37], #bbc
        [29,30,31], #bca
        [32,37,37], #bcb
        [35,37,37], #bcc
        [37,13,37], #caa
        [15,16,17], #cab
        [37,19,37], #cac
        [21,22,23], #cba
        [24,37,37], #cbb
        [26,37,37], #cbc
        [37,30,37], #cca
        [32,37,37], #ccb
        [37,37,37]] #dead

    delta = np.zeros((38, 38), dtype = int)
    
       
    for j in range(38):
        for k in range(3):
            delta[j][transitions[j][k]] += 1

    

    # put in np.array  to index
    
   
    # and then into Matrix
    delta = sp.Matrix(delta)
    delta = delta**inputSize
    # print(delta.shape)
    
    S = zeros(1, 38)
    F = ones(38, 1)
    F[37] = 0
    S[0] = 1
    
    
    # print(S.shape)

    #ravi's words: everything is accepting execpt for the fail state
    
    
    # (1xN) * (MxN) * (Mx1)
    perms = Matrix(S*delta*F)
    # print(perms.shape)
    # print(perms[0])

    print "Input: n =", inputSize, '\t', "output:", perms[0]
    main()  
    return

def MinString(DFA):
#returns the alphabetical shortest string accepted by input: DFA
    #n - states - DFA.rows
    #m - inputs - DFA.cols
    #we know accepting state is index: 1
    #start state is index: n-2
    m = np.size(DFA, 1)
    n = np.size(DFA, 0)

    #input : column row is index n-1
        
    input = [0] * m
    for i in range(m):
        input[i] = DFA[n-1][i]
    #create empty FIFO-Queue: functs are: q.append(<value>) , q.popleft()
    found = False
    q = deque([])
    q.append(n-2) #index of start state, index k from earlier
    Visited = [0] * (n - 1)
    Label = [-1] * (n - 1)
    Parent = [-1] * (n - 1)
    Visited[0] = 1
    current = -1
    next = -1

    while(len(q) != 0):
        current = q.popleft()
        # for val in input:
        for val in range(m):
            next = DFA[current][val]
            if(next == 0):#same as if next is an accepting state
                Label[next] = input[val]
                Parent[next] = current
                found = True
                break
            else:
                if(Visited[next] == 0): #hasn't been visited before lets put it in the Queue
                    Parent[next] = current
                    Visited[next] = 1
                    q.append(next)

    output = ""

    if(found == False):
        return "No result found given DFA"
    else:
        #start with parent[0]
        cameFromState = Parent[0]
        cameFromValue = Label[0]
        output = str(cameFromValue) + output
        #while the cameFromState != [n-2]
        while(cameFromState != n-2): #n-2 is the index of start state everytime
            print "cameFromValue: ", cameFromValue
            cameFromValue = Label[cameFromState]
            cameFromState = Parent[cameFromState]
            output = str(cameFromValue) + output

    return output



def smallestMultiple(k, S):
#k => number of smallest multiple applied
#S => non-empty subset of { 0,1,...,9}, we expect this to be set type container
#returns the smallest positive value which is a multiple of k only containing S as values

    currentK = 0
    M = np.zeros((k+2, 10), dtype = int)

    for cols in range(10):
        M[k][cols] = currentK
        currentK = (currentK + 1) % k
        M[k+1][cols] = cols #we want to know what input : column

    currentK =  0
    for rows in range(k):
        for cols in range(10):
            M[rows][cols] = currentK
            currentK = (currentK + 1) % k

    #only keep columns which exist in S for matrix
    # print(M)
    accum = 0
    onlyZeroInS = False;
    for c in range(10):
        #if not in the set remove that column, if it is make sure 0 isnt the only member in S
        if( not c in S):
            #this logic does not, after one is removed the index c refers to is no longer valid
                #keep track of how many time we remove, storing an accumulator then doing remove[c - accumulator]
            
            M = np.delete(M, c - accum, 1) #remove column c on M
            accum += 1
        else:
            if( c == 0):
                onlyZeroInS =  True
            else:
                onlyZeroInS = False

    #if S only conists of 0, then we actually can't find a valid (+int)input string
    if (onlyZeroInS == False):
        #one problem we have is we dont know distinctly which column index refers to which input
        #some more data may have to be put in Matrix to be able to know this answer inside MinString()
        shortestString = MinString(M)
        return "Shortest input string is: ", shortestString
    else:
        return "Shortest input string does not exist with given set S, accepted input cannot be found with only 0s."


def problem2():
    k = input("Please enter the value of k: ")
    s_digit = input("Please enter the first permitted digit: ")
    S_set = []
    while(s_digit != -1):
        S_set.append(s_digit)
        s_digit = input("Please enter the next permitted digit, (-1 to indicate if no more digits): ")
    x = len(S_set)
    if (x == 1 and S_set[0] == 0):
        print("A singleton set containing just 0 is not accepted, reentering problem...")
        problem2()
    print smallestMultiple(k, S_set)
    main()
    return

def main():
#goal: output the number of strings of length n, that satisfy the transitions's logic
    option = input("Problem 1 or 2? (enter 3 to exit): ")
    while (option != 1 or option != 2 or option != 3):
        if (option == 1):
            problem1()
        elif (option == 2):
            problem2()
        elif (option == 3):
            print("Have a great day!")
            sys.exit(0)
        else:
            option = input("Please enter '1' for problem 1, '2' for problem 2, or '3' to exit: ")
    return
main();
